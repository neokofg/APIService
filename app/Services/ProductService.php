<?php

namespace App\Services;

use App\Models\Product;
use App\Models\UserBuyHistory;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService {

    public function index($request): Paginator
    {
        $perPage = $request->first ?? 15;
        $pageName = 'products';
        $page = $request->page ?? 1;
        return Product::with('user')->paginate($perPage, ['*'], $pageName, $page);
    }


    public function find($request): mixed
    {
        return Product::where('id', '=', $request->id)->with('user','rentedUsers','rents')->first();
    }

    public function buy($request): mixed
    {
        $user = Auth::user();
        $product = Product::find($request->id);
        if($product->getIsBuyedAttribute()){
            return null;
        } else {
            DB::transaction(function () use($product, $user){
                $product->user_id = $user->id;
                $product->save();

                $buyHistory = new UserBuyHistory();
                $buyHistory->user_id = $user->id;
                $buyHistory->product_id = $product->id;
                $buyHistory->save();
            });

            return $product->fresh(['user']);
        }
    }

    public function update($request): mixed
    {
        $user = Auth::user();
        $product = Product::find($request['id']);
        if($product->user->id == $user->id) {
            $product->update($request);
            return $product->fresh(['user']);
        } else {
            return null;
        }
    }

    public function rent($request) {
        // Получаем авторизованного пользователя
        $user = Auth::user();
        // Получаем продукт по id из запроса
        $product = Product::find($request['id']);
        // Получаем количество часов аренды
        $hours = $request->hours;
        // Валидация
        if(!$product->user OR !$product->is_rentable OR $product->user->id == $user->id){
            // Продукт не найден, не доступен для аренды, или пользователь является владельцем
            return null;
        }
        // Проверка наличия активных аренд
        if($product->rents->isNotEmpty()) {
            // Перебираем активные аренды
            foreach($product->rents as $rent) {
                // Проверяем, арендовал ли уже текущий пользователь
                if($rent->user && $rent->user->id == $user->id) {
                    // Подсчитываем новое кол-во часов с учетом текущей аренды
                    $totalHours = intval($rent->rent_hours) + intval($hours);
                    // Ограничение - не более 24 часов
                    if($totalHours > 24){
                        return null;
                    }
                    // Обновляем данные текущей аренды
                    $rent->rent_hours = $totalHours;
                    $rent->rent_end_date = Carbon::parse($rent->rent_end_date)->addHours($hours);
                    $rent->save();
                }
            }
        } else {
            // Если аренд еще нет - создаем новую
            $product->rentedUsers()->attach($user->id, [
                'rent_hours' => $hours,
                'rent_end_date' => now()->addHours($hours)
            ]);
        }
        // Возвращаем продукт
        return $product->fresh(['user','rentedUsers']);
    }
}
