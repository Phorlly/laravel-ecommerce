<?php

namespace App\Http\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    //add item to cart
    public static function addItemToCart($productId)
    {
        $items = self::getItems();
        $existingItem = null;
        foreach ($items as $key => $item) {
            if ($item['product_id'] == $productId) {
                $existingItem = $key;
                break;
            }
        }

        if ($existingItem !== null) {
            $items[$existingItem]['quantity']++;
            $items[$existingItem]['total_price'] =
                $items[$existingItem]['quantity'] *
                $items[$existingItem]['unit_price'];
        } else {
            $model = Product::where('id', $productId)->first(['id', 'name', 'price', 'images']);
            if ($model) {
                $items[] = [
                    'product_id' => $productId,
                    'name' => $model->name,
                    'quantity' => 1,
                    'unit_price' => $model->price,
                    'total_price' => $model->price,
                    'image' => $model->images[0],
                ];
            }
        }
        self::addItemsToCookie($items);

        return count($items);
    }

    //add item to cart with quantity
    public static function addItemToCartWithQuantity($productId, $quantity = 1)
    {
        $items = self::getItems();
        $existingItem = null;
        foreach ($items as $key => $item) {
            if ($item['product_id'] == $productId) {
                $existingItem = $key;
                break;
            }
        }

        if ($existingItem !== null) {
            $items[$existingItem]['quantity'] = $quantity;
            $items[$existingItem]['total_price'] =
                $items[$existingItem]['quantity'] *
                $items[$existingItem]['unit_price'];
        } else {
            $model = Product::where('id', $productId)->first(['id', 'name', 'price', 'images']);
            if ($model) {
                $items[] = [
                    'product_id' => $productId,
                    'name' => $model->name,
                    'quantity' => $quantity,
                    'unit_price' => $model->price,
                    'total_price' => $model->price,
                    'image' => $model->images[0],
                ];
            }
        }
        self::addItemsToCookie($items);

        return count($items);
    }

    //remove item from cart
    public static function removeItem($productId)
    {
        $items = self::getItems();
        foreach ($items as $key => $item) {
            if ($item['product_id'] == $productId) {
                unset($items[$key]);
                break;
            }
        }
        self::addItemsToCookie($items);

        return $items;
    }

    //add cart items cookie
    public static function addItemsToCookie($items)
    {
        Cookie::queue('items', json_encode($items), 60 * 24 * 30);
    }

    //clear cart items from cookie
    public static function clearItems()
    {
        // Cookie::queue('items', null);
        Cookie::queue(Cookie::forget('items'));
    }

    //get all cart items from cookie
    public static function getItems()
    {
        $items = json_decode(Cookie::get('items'), true);
        if (!$items) {
            return [];
        }

        return $items;
    }

    //imcrement item quantity
    public static function incrementQuantity($productId)
    {
        $items = self::getItems();
        foreach ($items as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity']++;
                $item['total_price'] = $item['quantity'] * $item['unit_price'];
                break;
            }
        }
        self::addItemsToCookie($items);

        return $items;
    }

    //decrement item quantity
    public static function decrementQuantity($productId)
    {
        $items = self::getItems();
        foreach ($items as &$item) {
            if ($item['product_id'] == $productId) {
                if ($item['quantity'] > 1) {
                    $item['quantity']--;
                    $item['total_price'] = $item['quantity'] * $item['unit_price'];
                } else {
                    self::removeItem($productId);
                }
                break;
            }
        }
        self::addItemsToCookie($items);

        return $items;
    }

    //calculate grand total
    public static function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_price'));
    }
}
