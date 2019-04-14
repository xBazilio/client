<?php

declare(strict_types=1);

/*
 * This file is part of the Tarantool Client package.
 *
 * (c) Eugene Leonovich <gen.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tarantool\Client\Exception;

use Tarantool\Client\IProto;
use Tarantool\Client\Response;

final class RequestFailed extends \RuntimeException implements ClientException
{
    public static function fromErrorResponse(Response $response) : self
    {
        return new self(
            $response->getBodyField(IProto::ERROR),
            $response->getHeaderCode() & (Response::TYPE_ERROR - 1)
        );
    }

    public static function unknownSpace(string $spaceName) : self
    {
        return new self(\sprintf("Space '%s' does not exist", $spaceName));
    }

    public static function unknownIndex(string $indexName, int $spaceId) : self
    {
        return new self(\sprintf(
            "No index '%s' is defined in space #%d",
            $indexName,
            $spaceId
        ));
    }
}
