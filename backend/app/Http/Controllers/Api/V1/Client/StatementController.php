<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Client\Statement\StoreRequest;
use App\Http\Requests\Api\Client\Statement\UpdateRequest;
use App\Http\Resources\Api\V1\Client\StatementResource;
use App\Models\Statement;

class StatementController extends Controller
{
    public function index(){
        $search = request()->search;
        $user = auth()->guard('client')->user();
        $limit = request()->rowsPerPage;
        $statemnt = Statement::where('user_id', $user->id);

        if($search) {
            $statemnt->where('name', 'like', "%$search%");
        }

        $data = $statemnt->paginate($limit);
        return StatementResource::collection($data)->additional(['success'  => true]);
    }

    public function store(StoreRequest $request)
    {
        Statement::create($request->validated());
        return ['success' => true, 'message' => 'Successfully stored'];
    }

    public function update(UpdateRequest $request)
    {
        $user = auth()->user();
        $statement = Statement::where([['user_id', $user->id], ['id', $request->id]])->firstOrFail();
        $statement->update($request->validated());
        return ['success' => true, 'message' => 'Successfully updated'];
    }

    public function destroy($id)
    {
        $user = auth()->guard('client')->user();
        $statement = Statement::where([['user_id', $user->id], ['id', $id]])->firstOrFail();
        $statement->delete();
        return ['success' => true, 'message' => 'Removed successfully'];
    }
}
