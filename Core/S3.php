<?php

namespace Core;
require '../vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use App\Config;

/**
 * Class S3
 * @package Core
 */
class S3
{

    /**
     * @var S3Client
     */
    public $s3;

    /**
     * @var string
     */
    public $bucket;

    /**
     * S3 constructor.
     */
    public function __construct()
    {
        $this->s3     = new S3Client([
            'version'     => 'latest',
            'region'      => 'us-east-1',
            'credentials' => [
                'key'    => Config::S3_ACCESS_KEY,
                'secret' => Config::S3_SECRET_KEY
            ]
        ]);
        $this->bucket = Config::S3_BUCKET;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return array
     */
    public function uploadObject($filePath = '', $fileName = '')
    {
        try {
            // Upload data.
            $result = $this->s3->putObject(array(
                'Bucket'     => $this->bucket,
                'Key'        => $fileName,
                'SourceFile' => $filePath,
                'ACL'        => 'public-read'
            ));

            return ['success' => true, 'objectURL' => $result['ObjectURL']];
        } catch (S3Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }

    /**
     * @param string $fileName
     * @return array
     */
    public function deleteObject($fileName = '')
    {
        try {
            $result = $this->s3->deleteObject(array(
                'Bucket' => $this->bucket,
                'Key'    => $fileName
            ));
            return ['success' => true];
        } catch (S3Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
