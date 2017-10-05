<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\Advertise;


/**
 * Class AdvertiseRepository
 * @package App\Repositories\Admin
 */
class AdvertiseRepository
{

    /**
     * @var Menu
     */
    public $model;

    /**
     *
     */
    public function __construct()
    {
        $this->model = new Advertise();

    }

    /**
     * @param $params
     * @param $filename
     * @return bool
     */
    public function insertAdvertiseData($params, $filename)
    {
        return $this->model->insertAdvertiseData($params, $filename);
    }

    /**
     * @param $params
     * @return bool
     */
    public function updateAdvertiseData($params, $filename)
    {
        return $this->model->updateAdvertiseData($params, $filename);
    }

    /**
     * @param $id
     * @return bool
     */
    public function getAdvertiseById($id)
    {
        return $this->model->getAdvertiseById($id);
    }

    /**
     * @param $params
     */
    public function getAdvertiseAjaxPagination($params)
    {
        return $this->model->getAdvertiseAjaxPagination($params);
    }

    /**
     * @param $params
     */
    public function bulkDeleteAdvertise($params)
    {
        return $this->model->bulkDeleteAdvertise($params);
    }

    /**
     * @return bool
     */
    public function getAll()
    {
        return $this->model->getAll();
    }

    /**
     * @param int $advertiseId
     */
    public function removeBannerImage($advertiseId = 0)
    {
        $post = $this->model->getAdvertiseById($advertiseId);
        if ($post && $post[0]['banner_image']) {
            $target_dir = Config::F_BANNER_IMAGE_ROOT;
            $target_file = $target_dir . $post[0]['banner_image'];
            try {
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
            } catch (Exception $e) {

            }
        }
    }

    /**
     * @param $filedata
     * @return array
     */
    public function uploadBannerImage($filedata)
    {
        $target_dir = Config::F_BANNER_IMAGE_ROOT;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($filedata["name"]);
        if (!file_exists($target_file)) {
            if (move_uploaded_file($filedata["tmp_name"], $target_file)) {
                return ['success' => true, 'filename' => $filedata["name"]];
            } else {
                return ['success' => false, 'messages' => ['Failed to upload Banner Image.']];
            }
        } else {
            return ['success' => true, 'filename' => $filedata["name"]];
        }

    }


}
