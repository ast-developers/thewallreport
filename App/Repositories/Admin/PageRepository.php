<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\Page;
use Core\S3;


/**
 * Class PageRepository
 * @package App\Repositories\Admin
 */
class PageRepository
{
    /**
     * @var Page
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Page();
    }


    /**
     * @param $params
     * @return bool
     */
    public function insertPageData($params, $featured_image)
    {
        return $this->model->insertPageData($params, $featured_image);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updatePageData($params, $featured_image)
    {
        return $this->model->updatePageData($params, $featured_image);
    }


    /**
     * @param $id
     * @return bool
     */
    public function getPageById($id)
    {
        return $this->model->getPageById($id);
    }


    /**
     * @param $params
     */
    public function getPageAjaxPagination($params)
    {
        return $this->model->getPageAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeletePage($params)
    {
        $page_ids = explode(',', $params['data_ids']);
        foreach ($page_ids as $id) {
            $this->removeFeaturedImage($id);
        }
        return $this->model->bulkDeletePages($params);
    }

    /**
     * @return bool
     */
    public function getAll()
    {

        return $this->model->getAll();

    }

    /**
     * @param $fileData
     * @return array
     */
    public function uploadFeaturedImage($fileData)
    {
        $filePath = $fileData['tmp_name'];
        $name     = time() . "_" . basename($fileData["name"]);
        $fileName = Config::S3_FEATURE_IMAGE_DIR . "/" . $name;
        $s3       = new S3();
        $upload   = $s3->uploadObject($filePath, $fileName);
        if ($upload['success']) {
            return ['success' => true, 'filename' => $name];
        } else {
            return ['success' => false, 'messages' => ['Failed to upload Featured Image.']];
        }

    }

    /**
     * @param int $pageId
     * @return array
     */
    public function removeFeaturedImage($pageId = 0)
    {
        $page = $this->model->getPageById($pageId);
        if ($page && $page[0]['featured_image']) {
            $fileName = Config::S3_FEATURE_IMAGE_DIR . "/" . $page[0]['featured_image'];
            $s3       = new S3();
            $delete   = $s3->deleteObject($fileName);
            if ($delete['success']) {
                return ['success' => true];
            } else {
                return ['success' => false, 'messages' => ['Failed to delete Featured Image.']];
            }
        }
    }

    /**
     * @param $slug
     * @return bool
     */
    public function checkSlugExistOrNot($slug)
    {
        return $this->model->checkSlugExistOrNot($slug);
    }

}
