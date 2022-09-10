<?php

namespace App\Services\Lending;

use App\Models\Book;
use App\Models\Configuration;
use App\Models\Lending;
use App\Services\Admin\BookService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LendingService
{
    public function __construct(protected BookService $bookService)
    {
    }

    /**
     * @throws Exception
     */
    public function borrowBook($user, $book): Model|Lending
    {
        $user->abortIfUserHasNoSubscription();
        $user->abortIfUserHasInvalidAccessLevelAndPlan($book);
        $this->abortIfBookIsUnavailable($book);

        $lending =  $this->createLendingRecord(
            $user->id,
            $book->id,
            $user->activeSubscription()->plan->borrow_period
        );
        $this->bookService->updateBookStatus($book, Book::STATUS['borrowed']);
        return $lending->refresh();
    }

    public function createLendingRecord($userId, $bookId, $borrowPeriod): Model|Lending
    {
        return Lending::create([
            'book_id' => $bookId,
            'user_id' => $userId,
            'date_time_borrowed' => now(),
            'date_time_due' => now()->addDays($borrowPeriod),
        ]);
    }

    /**
     * @throws Exception
     */
    public function markLendingAsReturned($lending)
    {
        $this->abortIfLendingHasAlreadyBeenReturned($lending);
        $lendingPoints = $this->getLendingPoints($lending);
        $lending->update([
            'status' => Lending::STATUS['returned'],
            'date_time_returned' => now(),
            'points' => Carbon::parse($lending->date_time_due)->gt(now())
                ? $lending->points + $lendingPoints
                : $lending->points - $lendingPoints
        ]);
        $this->bookService->updateBookStatus($lending->book, Book::STATUS['available']);
        return $lending;
    }

    protected function getLendingPoints($lending): int
    {
        return (int)Carbon::parse($lending->date_time_due)->gt(now())
            ? Configuration::value(Configuration::ADDABLE_POINT)
            : Configuration::value(Configuration::DEDUCTIBLE_POINT);
    }

    /**
     * @throws Exception
     */
    private function abortIfBookIsUnavailable($book): void
    {
        if ($book->status != Book::STATUS['available']) {
            throw new Exception(
                'This book is currently not unavailable.'
            );
        }
    }

    /**
     * @throws Exception
     */
    private function abortIfLendingHasAlreadyBeenReturned($lending): void
    {
        if ($lending->status == Lending::STATUS['returned']) {
            throw new Exception(
                'This lending record has already been marked as returned.'
            );
        }
    }
}
