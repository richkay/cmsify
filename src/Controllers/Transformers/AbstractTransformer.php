<?php namespace Cmsify\Controllers\Transformers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractTransformer
{

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var int
     */
    protected $errorCode = 100;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param $collection
     * @return mixed
     */
    public function transformCollection($collection)
    {
        return array_map([$this, 'transform'], $collection);
    }

    /**
     * @param $item
     * @return mixed
     */
    abstract public function transform($item);

    /**
     * @param $data
     * @return mixed
     */
    public function respond($data)
    {
        return response($data, $this->statusCode, $this->headers);
    }

    public function respondWithPagination(LengthAwarePaginator $paginatorCollection)
    {
        return $this->respond([
            'data' => $this->transformCollection($paginatorCollection->all()),
            'paginator' => [
                'total_items' => $paginatorCollection->total(),
                'total_pages' => ceil($paginatorCollection->total()/ $paginatorCollection->perPage()),
                'current_page' => $paginatorCollection->currentPage(),
                'limit' => $paginatorCollection->perPage(),
            ]
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param int $errorCode
     * @return $this
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function respondWithError($message)
    {
        return $this->respond([
            'errros' => [
                'message' => $message,
                'error_code' => $this->errorCode,
                'status_code' => $this->statusCode
            ]
        ]);
    }

}