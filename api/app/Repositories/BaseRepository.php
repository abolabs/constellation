<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use MeiliSearch\Endpoints\Indexes;

abstract class BaseRepository
{
    public const DEFAULT_LIMIT = 100;

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get searchable fields array.
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model.
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance.
     *
     * @return Model
     *
     * @throws \Exception
     */
    public function makeModel()
    {
        $tmpModel = $this->app->make($this->model());

        if (! $tmpModel instanceof Model) {
            throw new InvalidArgumentException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $tmpModel;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param  array  $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = self::DEFAULT_LIMIT, $columns = ['*'])
    {
        $query = $this->allQuery();

        return $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->orWhere($key, 'like', '%'.$value.'%');
                }
            }
        }

        if (! is_null($skip)) {
            $query->skip($skip);
        }

        if (! is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria.
     *
     * @param  array  $search
     * @param  int|null  $skip
     * @param  int|null  $limit
     * @param  array  $columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Retrieve all records with given filter criteria, with pagination
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function apiAll(array $search = [], ?int $perPage = self::DEFAULT_LIMIT, ?int $page = 0, ?string $order = null, array $columns = ['*'])
    {
        $fullTextSearch = '';
        $filters = [];
        if (isset($search['filter'])) {
            if (isset($search['filter']['q'])) {
                $fullTextSearch = $search['filter']['q'];
                unset($search['filter']['q']);
            }

            $excludeFilters = [];
            if (isset($search['filter']['_exclude']) && ($excludeFilters = $search['filter']['_exclude'])) {
                unset($search['filter']['_exclude']);
            }

            foreach ($excludeFilters as $filterKey => $excludedValue) {
                if (is_array($excludedValue)) {
                    $filters[] = $filterKey." != '".implode("' AND ".$filterKey." != '", $excludedValue)."'";
                } else {
                    $filters[$filterKey] = $filterKey." != '".$excludedValue."'";
                }
            }

            foreach ($search['filter'] as $filterKey => $searchValue) {
                if (is_array($searchValue)) {
                    $filters[] = $filterKey." = '".implode("' OR ".$filterKey." = '", $searchValue)."'";
                } else {
                    $filters[$filterKey] = $filterKey." = '".$searchValue."'";
                }
            }
        }

        if (count($filters) > 0) {
            $query = $this->model->search($fullTextSearch, function (Indexes $index, $query, $options) use ($filters, $perPage) {
                $options['filter'] = implode(' AND ', $filters);
                $options['limit'] = $perPage ?? BaseRepository::DEFAULT_LIMIT;

                return $index->rawSearch($query, $options);
            });
        } else {
            $query = $this->model->search($fullTextSearch);
        }

        if (! is_null($order)) {
            $orderConfig = explode('-', $order);
            $orderType = count($orderConfig) > 1 ? 'DESC' : 'ASC';
            $query->orderBy(end($orderConfig), $orderType);
        }

        return $query->paginate($perPage, $columns, $page);
    }

    /**
     * Create model record.
     *
     * @param  array  $input
     * @return Model
     */
    public function create($input)
    {
        $tmpModel = $this->model->newInstance($input);

        $tmpModel->save();

        return $tmpModel;
    }

    /**
     * Find model record for given id.
     *
     * @param  int  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id.
     *
     * @param  array  $input
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        $query = $this->model->newQuery();

        $tmpModel = $query->findOrFail($id);

        $tmpModel->fill($input);

        $tmpModel->save();

        return $tmpModel;
    }

    /**
     * @param  int  $id
     * @return bool|mixed|null
     *
     * @throws \Exception
     */
    public function delete($id)
    {
        $query = $this->model->newQuery();

        $tmpModel = $query->findOrFail($id);

        return $tmpModel->delete();
    }
}
