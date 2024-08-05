<?php

namespace App\Traits\ModelsTrait;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

trait GeneralCrudTrait
{
    public function saveModel(array $data)
    {
        return $this->create($data);
    }

    public function insertModel(array $data)
    {
        return $this->insert($data);
    }

    public function getList($limit = 100000000, $orderBy = ['id' => 'desc'])
    {
        $this->cacheable && $limit = 100000000;
        $key = strtoupper($this->table) . "_GETLIST";

        if ($this->cacheable) {
            $list = Cache::get($key);
            if ($list) {
                return $list;
            }
        }

        $list = $this->filter([], $orderBy)->paginate($limit);

        if ($this->cacheable) {
            Cache::put($key, $list, now()->addMinutes($this->cacheMinutes));
        }

        return $list; //->paginate($limit);
    }

    public function getById($id)
    {
        if ($this->cacheable) {
            $list = $this->getList();

            return  $list->where('id', $id)->firstOrFail();
        }

        return $this->findOrFail($id);
    }

    public function getByIdAndLock($id)
    {
        return $this->where('id', $id)->lockForUpdate()->firstOrFail();
    }

    public function editModel($id, array $data)
    {
        $model = $this->findOrFail($id);
        $model->update($data);

        $this->clearCache();

        return $model;
    }

    public function deleteById($id)
    {
        $model = $this->findOrFail($id);
        $this->clearCache();

        return $model->delete();
    }

    public function scopeFilter($query, $fields, $orderBy)
    {

        if (isset($fields['from'])) {
            $query->where('created_at', '>=', $fields['from']);
        }
        if (isset($fields['to'])) {
            $query->where('created_at', '<=', $fields['to']);
        }
        foreach ($fields as $field => $value) {
            if ($field == "from" || $field == "to") {
                continue;
            }

            if ($field == "orWhere") {
                if (is_array($value)) {
                    $query->where(function ($query) use ($field, $value) {
                        foreach ($value as $obj) {

                            $query->where(function ($query) use ($obj) {
                                foreach ($obj as $k => $v) {
                                    $query->orWhere($k, $v);
                                }
                            });
                        }
                    });
                }
            } else {
                if (is_array($value)) {
                    $query->where(function ($query) use ($field, $value) {
                        foreach ($value as $v) {
                            $query->orWhere($field, $v);
                        }
                    });
                } else {
                    $query->where($field, $value);
                }
            }
        }
        foreach ($orderBy as $field => $direction) {
            $query->orderBy($field, $direction);
        }
        return $query;
    }

    public function _filter($fields, $orderBy = ['id' => 'desc'], $limit = 15)
    {
        return $this->filter($fields, $orderBy)->paginate($limit);
    }
    
    public function filterByDateRangeAndMobile($fields, $startDate = null, $endDate = null,$dateField='created_at', $mobile = null, $orderBy = ['id' => 'desc'], $limit = 15)
    {

        $query = $this->filter($fields, $orderBy);
        if ($startDate || $endDate) {
            if ($startDate) {
                $startDate = Carbon::parse($startDate)->startOfDay();
            }
            if ($endDate) {
                $endDate = Carbon::parse($endDate)->endOfDay();
            }
            
            if ($startDate && $endDate) {
                $query->whereBetween($dateField, [$startDate, $endDate]);
            } elseif ($startDate) {
                $query->where($dateField, '>=', $startDate);
            } elseif ($endDate) {
                $query->where($dateField, '<=', $endDate);
            }
        }
        if ($mobile) {
            $query->whereHas('user', function ($q) use ($mobile) {
                $q->where('mobile', $mobile);
            });
        }

        return $query->paginate($limit);
    }
    public function search($fields, $query, $orderBy = ['id' => 'desc'], $limit = 10)
    {

        $results = $this::query();

        foreach ($fields as $field) {
            $results->orWhere($field, 'ILIKE', '%' . $query . '%');
        }
        foreach ($orderBy as $column => $direction) {
            $results->orderBy($column, $direction);
        }
        return $results->take($limit)->get();
    }

    public function firstOrsave(array $find, array $data = [])
    {
        $data = array_merge($data, $find);
        return $this->firstOrCreate($find, $data);
    }

    /**
     * @return void
     */
    public function clearCache(): void
    {
        if ($this->cacheable) {
            $key = strtoupper($this->table) . "_GETLIST";
            Cache::forget($key);
        }
    }
}
