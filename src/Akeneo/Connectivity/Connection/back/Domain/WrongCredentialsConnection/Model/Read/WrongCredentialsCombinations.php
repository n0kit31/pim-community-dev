<?php
declare(strict_types=1);

namespace Akeneo\Connectivity\Connection\Domain\WrongCredentialsConnection\Model\Read;

/**
 * @author    Willy Mesnage <willy.mesnage@akeneo.com>
 * @copyright 2020 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class WrongCredentialsCombinations
{
    /** @var WrongCredentialsCombination[] */
    private $wrongCombinations;

    public function __construct(array $combinations)
    {
        $this->wrongCombinations = [];
        foreach ($combinations as $combination) {
            $connection = $combination['connection_code'];
            $this->wrongCombinations[$connection] = new WrongCredentialsCombination($connection);

            foreach ($combination['users'] as $username => $date) {
                $this->wrongCombinations[$connection]->addUser(
                    $username,
                    new \DateTime($date, new \DateTimeZone('UTC'))
                );
            };
        }
    }

    public function normalize(): array
    {
        return array_reduce(
            $this->wrongCombinations,
            function (array $normalized, WrongCredentialsCombination $wrongCombination) {
                $normalized[$wrongCombination->connectionCode()] = $wrongCombination->normalize();

                return $normalized;
            },
            []
        );
    }
}
