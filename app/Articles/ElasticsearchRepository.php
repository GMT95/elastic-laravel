<?php

namespace App\Articles;

use App\Models\Headline;
use Elastic\Elasticsearch\Client;
use ElasticPaginator;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ElasticsearchRepository implements SearchRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;
    private $size;
    private $query;
    private $currentPage;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
        $this->size = 20;
        $this->query = [];
        $this->currentPage = 1;
    }

    public function search(array $searchParams): LengthAwarePaginator
    {
        $items = $this->searchOnElasticsearch($searchParams);

        return $this->buildCollection($items->asArray());
    }

    private function searchOnElasticsearch(array $searchParams)
    {
        $this->query = $searchParams;
        $this->currentPage = Paginator::resolveCurrentPage();
        
        $from = ( ($this->currentPage - 1 ) * $this->size ) + 1;

        $model = new Headline;

        $elasticQuery = [
            'query' => [
                'bool' => []
            ]
        ];

        // text query
        if($this->query['q']) {
            $elasticQuery['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $this->query['q'],
                    'type' => 'phrase',
                    'fields' => [
                        'headline^2',
                        'short_description',
                        'authors'
                    ]
                ],
            ];
        }

        // category query
        if($this->query['category']) {
            $elasticQuery['query']['bool']['must'][] = [
                'match' => [
                    'category' => $this->query['category']
                ]
            ];
        }

        // date filters
        if($this->query['start_date'] || $this->query['end_date']) {
            $dateFilters = [
                'gte' => $this->query['start_date'],
                'lte' => $this->query['end_date'],
            ];

            $elasticQuery['query']['bool']['filter'] = [
                "range" => [
                    "date" => array_filter($dateFilters)
                ]
            ];
        }

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => $elasticQuery,
            "from" => $from,
            "size" => $this->size,
            "track_total_hits" => true
        ]);

        return $items;
    }

    private function buildCollection(array $items): LengthAwarePaginator
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        $hits = Headline::query()
                    ->whereIn('id', $ids)
                    ->get()
                    ->sortBy('id');
        $total = $items["hits"]["total"]["value"];

        $urlQuery = http_build_query([...Paginator::resolveQueryString(), 'page' => null]);

        $paginatedHeadlines = new LengthAwarePaginator(
            $hits,
            $total,
            $this->size,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath() . "?$urlQuery"]
        );

        return $paginatedHeadlines;
    }
}