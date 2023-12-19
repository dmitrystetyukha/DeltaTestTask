<?php

namespace App\Controller;

use App\Service\InfographicService;
use JsonException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zaphyr\HttpMessage\Response;
use Zaphyr\HttpMessage\Stream;

/**
 * Infographic controller class
 */
class InfographicController
{
    /**
     * @return MessageInterface
     * @throws JsonException
     */
    public function getAction(ServerRequestInterface $request, array $params): MessageInterface
    {
        $date = $params['date'];
        $resultData = (new InfographicService())->getInfoByDate($date);

        $respBody = new Stream('php://temp', 'r+');
        $respBody->write(json_encode($resultData, JSON_THROW_ON_ERROR));

        return (new Response())
            ->withBody($respBody)
            ->withHeader('Content-Type', 'application/json');
    }
}