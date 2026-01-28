<? $selectedValue = $isPost ? $_POST[$selectName] : $_GET[$selectName]; ?>
<? if ($blankOption) : ?>
    <option value=""></option>
<? endif; ?>
<? foreach($options AS $i => $row) : ?>
    <? $value = $optionName ? $row['id'] : $i; ?>
    <? $name = $optionName ? $row[$optionName] : $row; ?>

    <? if (!$optionName || !$row[$parentField]) : ?>
        <option value="<?= $value ?>"
            <?= $value == $selectedValue && strlen($selectedValue) ? 'selected="selected"' : '' ?>
            <?= is_array($selectedValue) && in_array($value, $selectedValue) ? 'selected="selected"' : '' ?>
            <? foreach ($dataFields as $dataField) : ?>
                data-<?= $dataField ?>="<?= $row[$dataField] ?>"
            <? endforeach; ?>
            <?= in_array($value, $optionsDisabled) ? 'disabled' : '' ?>
        >
            <?//= ucfirst($name) ?>
            <?= $name ?>
        </option>
        <? if ($optionsChildren[$value]) : ?>
            <? foreach ($optionsChildren[$value] AS $row) : ?>
                <option value="<?= $row['id'] ?>"
                    <?= $row['id'] == $selectedValue && strlen($selectedValue) ? 'selected="selected"' : '' ?>
                    <?= is_array($selectedValue) && in_array($row['id'], $selectedValue) ? 'selected="selected"' : '' ?>
                    <?= in_array($value, $optionsDisabled) ? 'disabled' : '' ?>
                    <? foreach ($dataFields as $dataField) : ?>
                        data-<?= $dataField ?>="<?= $row[$dataField] ?>"
                    <? endforeach; ?>
                >
                    <?= str_repeat('&nbsp;', 4) ?>
                    <?//= ucfirst($row[$optionName]) ?>
                    <?= $row[$optionName] ?>
                </option>
            <? endforeach; ?>
        <? endif; ?>
    <? endif; ?>
<? endforeach; ?>