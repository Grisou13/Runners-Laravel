<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 02.03.2017
 * Time: 14:18
 */

namespace Api\Responses;

use League\Fractal\Pagination\CursorInterface;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
  /**
   * Serialize a collection.
   */
  public function collection($resourceKey, array $data)
  {
    return ($resourceKey) ? [ $resourceKey => $data ] : $data;
  }
  
  /**
   * Serialize an item.
   */
  public function item($resourceKey, array $data)
  {
    return ($resourceKey) ? [ $resourceKey => $data ] : $data;
  }
  public function null()
  {
    return null;
  }
  /**
   * Serialize the paginator.
   *
   * @param PaginatorInterface $paginator
   *
   * @return array
   */
  public function paginator(PaginatorInterface $paginator)
  {
    $currentPage = (int) $paginator->getCurrentPage();
    $lastPage = (int) $paginator->getLastPage();
    
    $pagination = [
      'total' => (int) $paginator->getTotal(),
      'count' => (int) $paginator->getCount(),
      'per_page' => (int) $paginator->getPerPage(),
      'current_page' => $currentPage,
      'total_pages' => $lastPage,
    ];
    
    $pagination['links'] = [];
    
    if ($currentPage > 1) {
      $pagination['links']['previous'] = $paginator->getUrl($currentPage - 1);
    }
    
    if ($currentPage < $lastPage) {
      $pagination['links']['next'] = $paginator->getUrl($currentPage + 1);
    }
    
    return ['pagination' => $pagination];
  }
  
  /**
   * Serialize the cursor.
   *
   * @param CursorInterface $cursor
   *
   * @return array
   */
  public function cursor(CursorInterface $cursor)
  {
    $cursor = [
      'current' => $cursor->getCurrent(),
      'prev' => $cursor->getPrev(),
      'next' => $cursor->getNext(),
      'count' => (int) $cursor->getCount(),
    ];
    
    return ['cursor' => $cursor];
  }
}