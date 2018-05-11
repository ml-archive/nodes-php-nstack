<?php

declare(strict_types=1);

namespace Nodes\NStack\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Nodes\NStack\Clients\Client;

/**
 * Class UrbanAirship.
 */
class NStackProvider
{
    /**
     * @var \Nodes\NStack\Clients\Client
     */
    protected $client;

    /**
     * NStackProvider constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param string $appId
     * @param string $restKey
     */
    public function __construct(string $appId, string $restKey)
    {
        $this->client = new Client($appId, $restKey);
    }

    /**
     * countries
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @return array
     */
    public function countries(): array
    {
        $response = $this->client->get('geographic/countries');

        $data = json_decode($response->getBody()->getContents(), true);

        return $data;
    }

    /**
     * pushLog
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param string                                   $provider
     * @param string                                   $key
     * @param string                                   $type
     * @param bool                                     $suceeded
     * @param array                                    $request
     * @param array                                    $response
     * @param null                                     $message
     * @param null                                     $userId
     * @param \Illuminate\Database\Eloquent\Model|null $relation
     * @return void
     */
    public function pushLog(
        string $provider,
        string $key,
        string $type,
        bool $suceeded,
        array $request,
        array $response,
        $message = null,
        $userId = null,
        Model $relation = null
    ) {
        $this->client->post('ugc/push-logs', [
            'json' => [
                'provider'      => $provider,
                'key'           => $key,
                'type'          => $type,
                'message'       => $message,
                'succeeded'     => $suceeded,
                'request'       => $request,
                'response'      => $response,
                'user_id'       => $userId,
                'relation_type' => $relation ? get_class($relation) : null,
                'relation_id'   => $relation ? $relation->id : null,
            ],
        ]);
    }

    /**
     * fileUpload
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param string (public, private, private-password) $privacy
     * @param Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param string                               $name
     * @return array
     */
    public function fileUpload(
        string $privacy,
        UploadedFile $uploadedFile,
        string $name,
        string $tags = null,
        Carbon $goneAt = null
    ): array {

        $multipart = [
            [
                'name'     => 'file',
                'contents' => fopen($uploadedFile->getRealPath(), 'r'),
                'filename' => $uploadedFile->getRealPath(),
            ],
            [
                'name'     => 'name',
                'contents' => $name,
            ],
            [
                'name'     => 'privacy',
                'contents' => $privacy,
            ],
            [
                'name'     => 'tags',
                'contents' => $tags,
            ],
        ];

        if ($goneAt) {
            $multipart[] = [
                'name'     => 'gone_at',
                'contents' => $goneAt->toDateTimeString(),
            ];
        }

        $response = $this->client->post('content/files', [
            'multipart' => $multipart,
        ]);

        return json_decode($response->getBody()->getContents(), true);;
    }
}
