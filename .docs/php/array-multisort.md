# Sort a multidimensional array

```php
function arrayMultiSortValue(): array
{
    $arArgs = func_get_args();
    $arData = array_shift($arArgs);

    foreach ($arArgs as $n => $field) {
        if (is_string($field)) {
            $arTmp = [];

            foreach ($arData as $key => $row) {
                $arTmp[$key] = $row[$field];
            }

            $arArgs[$n] = $arTmp;
        }
    }

    $arArgs[] = &$arData;
    call_user_func_array('array_multisort', $arArgs);

    return array_pop($arArgs);
}
```

Example:

```php
$arArray = [
    [
        'field_1' => 1,
        'field_2' => 1
    ],
    [
        'field_1' => 2,
        'field_2' => 2
    ]
    ...
];


$arResult = arrayMultiSortValue($arArray, 'field_1', SORT_ASC);
```
