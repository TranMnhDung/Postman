<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    // 🔹 GET /api/recipes
    public function index()
    {
        // Lấy danh sách kèm theo steps (nếu bảng steps tồn tại)
        return response()->json([
            'success' => true,
            'data' => Recipe::with(['steps'])->get() 
        ]);
    }

    // 🔹 GET /api/recipes/{id}
    public function show($id)
    {
        $recipe = Recipe::with(['steps'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $recipe
        ]);
    }

    // 🔹 POST /api/recipes (QUAN TRỌNG: Đã sửa phần này)
    public function store(Request $request)
    {
        // 1. Validate đúng tên cột title và các cột bắt buộc khác
        $request->validate([
            'title'        => 'required|string', // Sửa name -> title
            'description'  => 'nullable|string',
            'cooking_time' => 'required|integer', // Thêm cái này
            'servings'     => 'required|integer', // Thêm cái này
            'difficulty'   => 'required|string',  // Thêm cái này
            // Steps và Categories để nullable để tránh lỗi nếu chưa gửi lên
            'steps'        => 'nullable|array',
            'steps.*.step_order' => 'required|integer',
            'steps.*.content'    => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // 2. Tạo Recipe (Thêm user_id và các trường còn thiếu)
            $recipe = Recipe::create([
                'user_id'      => 1, // Tạm thời set cứng là 1 (Admin)
                'title'        => $request->title, // Khớp với Database
                'description'  => $request->description,
                'cooking_time' => $request->cooking_time,
                'servings'     => $request->servings,
                'difficulty'   => $request->difficulty,
                'status'       => 'Published'
            ]);

            // 3. Lưu steps (Chỉ chạy nếu có gửi steps lên)
            if ($request->has('steps')) {
                foreach ($request->steps as $step) {
                    $recipe->steps()->create($step);
                }
            }
            
            // (Tạm bỏ phần Category để giảm thiểu lỗi nếu chưa có bảng pivot)

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => $recipe->load('steps')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔹 PUT /api/recipes/{id}
    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        DB::beginTransaction();
        try {
            // Update dùng $request->all() hoặc chỉ định rõ field
            $recipe->update([
                'title'        => $request->title ?? $recipe->title,
                'description'  => $request->description ?? $recipe->description,
                'cooking_time' => $request->cooking_time ?? $recipe->cooking_time,
                'servings'     => $request->servings ?? $recipe->servings,
                'difficulty'   => $request->difficulty ?? $recipe->difficulty,
            ]);

            if ($request->has('steps')) {
                $recipe->steps()->delete();
                foreach ($request->steps as $step) {
                    $recipe->steps()->create($step);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'data' => $recipe->load('steps')]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 DELETE /api/recipes/{id}
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->steps()->delete();
        $recipe->delete();

        return response()->json(['success' => true, 'message' => 'Deleted successfully']);
    }
}