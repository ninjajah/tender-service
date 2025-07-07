<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TenderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'string|max:255',
                'date' => 'date_format:d.m.Y',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибки валидации',
                    'errors' => $validator->errors()
                ], 422);
            }

            $query = Tender::query();

            if ($request->has('name')) {
                $query->where('name', 'like', '%'.$request->name.'%');
            }

            if ($request->has('date')) {
                try {
                    $date = Carbon::createFromFormat('d.m.Y', $request->date)->startOfDay();
                    $query->whereDate('change_date', $date);
                } catch (\Exception $e) {
                    Log::error('Ошибка парсинга даты', ['error' => $e->getMessage()]);
                    return response()->json([
                        'success' => false,
                        'message' => 'Неверный формат даты. Используйте формат ДД.ММ.ГГГГ',
                        'error' => $e->getMessage()
                    ], 400);
                }
            }

            $tenders = $query->get();

            return response()->json([
                'success' => true,
                'data' => $tenders,
                'count' => $tenders->count(),
                'message' => 'Список тендеров успешно получен'
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка получения списка тендеров', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка сервера',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'external_code' => 'required|string|max:255|unique:tenders',
                'number' => 'required|string|max:255',
                'status' => ['required', 'string', Rule::in(['Открыто', 'Закрыто', 'Отменено'])],
                'name' => 'required|string|max:1000',
                'change_date' => 'required|date_format:d.m.Y H:i:s'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибки валидации',
                    'errors' => $validator->errors()
                ], 422);
            }

            $tender = Tender::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $tender,
                'message' => 'Тендер успешно создан'
            ], 201);

        } catch (\Exception $e) {
            Log::error('Ошибка создания тендера', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Не удалось создать тендер',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $tender = Tender::find($id);

            if (!$tender) {
                return response()->json([
                    'success' => false,
                    'message' => 'Тендер не найден'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $tender,
                'message' => 'Тендер успешно получен'
            ]);

        } catch (\Exception $e) {
            Log::error('Ошибка получения тендера', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Не удалось получить тендер',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
