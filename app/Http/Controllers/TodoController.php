<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="Todo API",
 *     version="1.0.0",
 *     description="A simple Todo API with CRUD operations"
 * )
 */
class TodoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/todos",
     *     summary="Get list of todos",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"completed", "in progress", "not started"})
     *     ),
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search in title and details",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort field",
     *         required=false,
     *         @OA\Schema(type="string", enum={"title", "status", "created_at"})
     *     ),
     *     @OA\Parameter(
     *         name="direction",
     *         in="query",
     *         description="Sort direction",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"})
     *     ),
     *     @OA\Response(response="200", description="List of todos")
     * )
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search in title and details
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('details', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sortField, $direction);

        return response()->json($query->paginate(10));
    }

    /**
     * @OA\Post(
     *     path="/api/todos",
     *     summary="Create a new todo",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","details","status"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string", enum={"completed", "in progress", "not started"})
     *         )
     *     ),
     *     @OA\Response(response="201", description="Todo created successfully")
     * )
     */
    public function store(StoreTodoRequest $request)
    {
        $todo = Todo::create($request->validated());
        return response()->json($todo, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/todos/{id}",
     *     summary="Update a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="details", type="string"),
     *             @OA\Property(property="status", type="string", enum={"completed", "in progress", "not started"})
     *         )
     *     ),
     *     @OA\Response(response="200", description="Todo updated successfully")
     * )
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        return response()->json($todo);
    }

    /**
     * @OA\Delete(
     *     path="/api/todos/{id}",
     *     summary="Delete a todo",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Todo deleted successfully")
     * )
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
