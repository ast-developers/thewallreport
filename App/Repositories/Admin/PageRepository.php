<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\Page;


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
     * @param $filedata
     * @return array
     */
    public function uploadFeaturedImage($filedata)
    {
        $target_dir = Config::F_FEATURED_IMAGE_ROOT;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($filedata["name"]);
        if (!file_exists($target_file)) {
            if (move_uploaded_file($filedata["tmp_name"], $target_file)) {
                return ['success' => true, 'filename' => $filedata["name"]];
            } else {
                return ['success' => false, 'messages' => ['Failed to upload Featured Image.']];
            }
        } else {
            return ['success' => true, 'filename' => $filedata["name"]];
        }

    }

    /**
     * @param int $userId
     */
    public function removeFeaturedImage($postid = 0)
    {
        $post = $this->model->getPageById($postid);
        if ($post && $post[0]['featured_image']) {
            $target_dir = Config::F_FEATURED_IMAGE_ROOT;
            $target_file = $target_dir . $post[0]['featured_image'];
            try {
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            } catch (Exception $e) {

            }
        }
    }

}
