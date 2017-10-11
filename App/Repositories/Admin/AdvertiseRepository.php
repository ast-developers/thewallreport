<?php

namespace App\Repositories\Admin;

use App\Config;
use App\Models\Advertise;
use Core\S3;


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
     * @return array
     */
    public function removeBannerImage($advertiseId = 0)
    {
        $advert = $this->model->getAdvertiseById($advertiseId);
        if ($advert && $advert[0]['banner_image']) {
            $fileName = Config::S3_ADVERT_IMAGE_DIR . "/" . $advert[0]['banner_image'];
            $s3       = new S3();
            $delete   = $s3->deleteObject($fileName);
            if ($delete['success']) {
                return ['success' => true];
            } else {
                return ['success' => false, 'messages' => ['Failed to delete Advertisement Image.']];
            }
        }
    }

    /**
     * @param $fileData
     * @return array
     */
    public function uploadBannerImage($fileData)
    {
        $filePath = $fileData['tmp_name'];
        $name     = time() . "_" . basename($fileData["name"]);
        $fileName = Config::S3_ADVERT_IMAGE_DIR . "/" . $name;
        $s3       = new S3();
        $upload   = $s3->uploadObject($filePath, $fileName);
        if ($upload['success']) {
            return ['success' => true, 'filename' => $name];
        } else {
            return ['success' => false, 'messages' => ['Failed to upload Advertisement Image.']];
        }
    }


}
