<?php


namespace Zler\Biz\Dao;


interface GeneralDaoInterface extends DaoInterface
{
    public function create($fields);

    public function update($id, array $fields);

    public function delete($id);

    public function get($id, $lock = false);

    public function search($conditions, $orderbys, $start, $limit);

    public function count($conditions);

    public function sum($conditions, $column);

    public function wave(array $ids, array $diffs);

    public function table();
}