<?php

namespace App\controllers\Api;

use Core\ApiController;
use Core\Request;
use Core\Connection;
use App\models\Reservation;

class ReservationController extends ApiController
{
    public function index(Request $request): string
    {
        $items = Reservation::all();
        return $this->json(['data' => $items], 200);
    }

    public function show(Request $request, array $params): string
    {
        $id = (int)($params['id'] ?? 0);
        $item = Connection::db_select(Reservation::tableName(), "ID=$id");
        if (!$item) {
            return $this->json(['error' => 'Not Found'], 404);
        }
        return $this->json(['data' => $item], 200);
    }

    public function store(Request $request): string
    {
        $body = $request->getBody();
        $now = date('Y-m-d H:i:s');
        $data = [
            'book_id' => (int)($body['book_id'] ?? 0),
            'user_id' => (int)($body['user_id'] ?? 0),
            'reservation_date' => $now,
            'return_date' => $body['return_date'] ?? $now,
            'status' => $body['status'] ?? 'active'
        ];
        if ($data['book_id'] <= 0 || $data['user_id'] <= 0) {
            return $this->json(['error' => 'Invalid data'], 422);
        }
        $created = Reservation::create($data);
        if (!$created) {
            return $this->json(['error' => 'Create failed'], 500);
        }
        return $this->json(['data' => $created], 201);
    }

    public function update(Request $request, array $params): string
    {
        $id = (int)($params['id'] ?? 0);
        $exists = Connection::db_select(Reservation::tableName(), "ID=$id");
        if (!$exists) {
            return $this->json(['error' => 'Not Found'], 404);
        }
        $body = $request->getBody();
        $data = [];
        foreach (['book_id','user_id','reservation_date','return_date','status'] as $f) {
            if (array_key_exists($f, $body)) {
                $data[$f] = $body[$f];
            }
        }
        $updated = Reservation::updateById($id, $data);
        return $this->json(['data' => $updated], 200);
    }

    public function destroy(Request $request, array $params): string
    {
        $id = (int)($params['id'] ?? 0);
        $exists = Connection::db_select(Reservation::tableName(), "ID=$id");
        if (!$exists) {
            return $this->json(['error' => 'Not Found'], 404);
        }
        Reservation::deleteById($id);
        return $this->json(['message' => 'Deleted'], 200);
    }
}


