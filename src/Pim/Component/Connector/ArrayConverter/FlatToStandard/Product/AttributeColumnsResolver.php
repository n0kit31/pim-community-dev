<?php

namespace Pim\Component\Connector\ArrayConverter\FlatToStandard\Product;

use Pim\Component\Catalog\AttributeTypes;
use Pim\Component\Catalog\Manager\AttributeValuesResolver;
use Pim\Component\Catalog\Repository\AttributeRepositoryInterface;
use Pim\Component\Catalog\Repository\CurrencyRepositoryInterface;

/**
 * Resolve attribute field information
 *
 * @author    Olivier Soulet <olivier.soulet@akeneo.com>
 * @copyright 2015 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AttributeColumnsResolver
{
    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    /** @var CurrencyRepositoryInterface */
    protected $currencyRepository;

    /** @var AttributeValuesResolver */
    protected $valuesResolver;

    /** @var array */
    protected $attributesFields = [];

    /** @var string */
    protected $identifierField;

    /**
     * @param AttributeRepositoryInterface $attributeRepository
     * @param CurrencyRepositoryInterface  $currencyRepository
     * @param AttributeValuesResolver      $valuesResolver
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        CurrencyRepositoryInterface $currencyRepository,
        AttributeValuesResolver $valuesResolver
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->attributeRepository = $attributeRepository;
        $this->valuesResolver = $valuesResolver;
    }

    /**
     * @return string
     */
    public function resolveIdentifierField()
    {
        if (empty($this->identifierField)) {
            $attribute = $this->attributeRepository->getIdentifier();
            $this->identifierField = $attribute->getCode();
        }

        return $this->identifierField;
    }

    /**
     * @return array
     */
    public function resolveAttributeColumns()
    {
        if (empty($this->attributesFields)) {
            // TODO: Put a Cursor to avoid a findAll on attributes (╯°□°)╯︵ ┻━┻
            $attributes = $this->attributeRepository->findAll();
            $currencyCodes = $this->currencyRepository->getActivatedCurrencyCodes();
            $values = $this->valuesResolver->resolveEligibleValues($attributes);
            foreach ($values as $value) {
                $fields = $this->resolveAttributeField($value, $currencyCodes);
                $this->attributesFields = array_merge($this->attributesFields, $fields);
            }
        }

        return $this->attributesFields;
    }

    /**
     * Resolves the attribute field name
     *
     * @param array $value
     * @param array $currencyCodes
     */
    protected function resolveAttributeField(array $value, array $currencyCodes)
    {
        $field = $this->resolveFlatAttributeName($value['attribute'], $value['locale'], $value['scope']);

        if (AttributeTypes::PRICE_COLLECTION === $value['type']) {
            $fields[] = $field;
            foreach ($currencyCodes as $currencyCode) {
                $currencyField = sprintf('%s-%s', $field, $currencyCode);
                $fields[] = $currencyField;
            }
        } elseif (AttributeTypes::METRIC === $value['type']) {
            $fields[] = $field;
            $metricField = sprintf('%s-%s', $field, 'unit');
            $fields[] = $metricField;
        } else {
            $fields[] = $field;
        }

        return $fields;
    }

    /**
     * Resolve the full flat attribute name depending on the $attributeCode, the $localeCode and the $scopeCode.
     *
     * Examples:
     *
     *  description-en_US-mobile
     *  name-ecommerce
     *  weight
     *
     * @param string $attributeCode
     * @param string $localeCode
     * @param string $scopeCode
     *
     * @return string
     */
    public function resolveFlatAttributeName($attributeCode, $localeCode, $scopeCode)
    {
        $field = $attributeCode;

        if (null !== $localeCode) {
            $field = sprintf('%s-%s', $field, $localeCode);
        }

        if (null !== $scopeCode) {
            $field = sprintf('%s-%s', $field, $scopeCode);
        }

        return $field;
    }
}
