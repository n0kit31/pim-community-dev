<?php

declare(strict_types=1);

namespace spec\Akeneo\Apps\Domain\Model\Write;

use Akeneo\Apps\Domain\Model\Write\AppLabel;
use PhpSpec\ObjectBehavior;

/**
 * @author Romain Monceau <romain@akeneo.com>
 * @copyright 2019 Akeneo SAS (http://www.akeneo.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class AppLabelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedThrough('create', ['Magento Connector']);
        $this->shouldBeAnInstanceOf(AppLabel::class);
    }

    function it_cannot_contains_a_string_longer_than_100_characters()
    {
        $this->beConstructedThrough('create', [str_repeat('a', 101)]);
        $this->shouldThrow(
            new \InvalidArgumentException('akeneo_apps.app.constraint.label.too_long')
        )->duringInstantiation();
    }

    function it_returns_the_app_label_as_a_string()
    {
        $this->beConstructedThrough('create', ['Magento Connector']);
        $this->__toString()->shouldReturn('Magento Connector');
    }

    function it_can_contains_an_empty_string()
    {
        $this->beConstructedThrough('create', ['']);
        $this->__toString()->shouldReturn('');
    }
}
