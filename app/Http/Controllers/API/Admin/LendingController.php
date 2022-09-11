<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lending\CreateLendingRequest;
use App\Http\Requests\Lending\UpdateLendingRequest;
use App\Http\Resources\LendingResource;
use App\Models\{Book, Lending, User};
use App\Services\Lending\LendingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LendingController extends Controller
{
    public function __construct(protected LendingService $lendingService)
    {
    }

    public function getLendings(): AnonymousResourceCollection
    {
        return LendingResource::collection(
            Lending::with('user')->paginate()
        );
    }

    public function getLending(Lending $lending): JsonResponse
    {
        return $this->successResponse(LendingResource::make(
            $lending->load('user')->first()
        ));
    }

    public function createLending(CreateLendingRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = User::whereId($data['user_id'])->first();
            $book = Book::whereId($data['book_id'])
                ->with(['accessLevels', 'plans'])->first();
            $user->abortIfUsersProfileIsNotUpdated();
            return $this->successResponse(
                LendingResource::make(
                    $this->lendingService->borrowBook($user, $book)
                )
            );
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }

    /**
     * @param Request $request
     * @param Lending $lending
     * @return JsonResponse
     * @throws Throwable
     */
    public function markLendingAsReturned(Request $request, Lending $lending): JsonResponse
    {
        try {
            DB::beginTransaction();
            $lending = $this->lendingService
                ->markLendingAsReturned($lending->load('book', 'user'));
            DB::commit();
            return $this->successResponse(LendingResource::make($lending));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->fatalErrorResponse($e);
        }
    }

    public function updateLending(UpdateLendingRequest $request, Lending $lending): JsonResponse
    {
        // work on this
        $data = $request->validated();
        $user = User::whereId($data['user_id'])->first();
        $book = Book::whereId($data['book_id'])
            ->with(['accessLevels', 'plans'])->first();
        $this->lendingService->updateLendingRecord($lending, $data);
        return $this->success('Lending Record updated successfully');
    }

    public function deleteLending(Request $request, Lending $lending): JsonResponse
    {
        try {
            $lending->delete();
            return $this->success('Lending Record deleted successfully');
        } catch (\Exception $e) {
            return $this->fatalErrorResponse($e);
        }
    }
}
