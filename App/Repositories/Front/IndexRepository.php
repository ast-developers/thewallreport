<?php

namespace App\Repositories\Front;

use App\Models\Advertise;
use App\Models\Post;

class IndexRepository
{

    public function __construct()
    {
        $this->post_model = new Post();
        $this->advertisement_model = new Advertise();
    }

    public function getFeaturedBanners()
    {
        return $this->post_model->getFeaturedBanners();
    }

    public function getAdvertisements(){
        $adds = [];
        $data = $this->advertisement_model->getAdvertisements();
        if(!empty($data)){
            foreach($data as $val){
                $adds[$val['position']] = $val;
            }
        }
        return $adds;
    }
}
