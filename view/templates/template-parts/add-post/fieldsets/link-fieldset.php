<?php
/**
 * @var array $errors
 * @var string $fieldName
 */
?>

<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="<?= esc($fieldName); ?>">Ссылка
        <span class="form__input-required">*</span>
    </label>
    <div class="form__input-section">
        <input class="adding-post__input form__input"
               id="<?= esc($fieldName); ?>"
               type="text"
               name="<?= esc($fieldName); ?>"
               value="<?= esc(getPostVal($fieldName)); ?>">

        <?php if (!empty($errors) && isset($errors[$fieldName])): ?>
            <?= includeTemplate('template-parts/add-post/field-error-text.php', [
                'errorTitle' => $errors[$fieldName]['title'] ?? null,
                'errorDesc' => $errors[$fieldName]['description'] ?? null,
            ]); ?>
        <?php endif; ?>
    </div>
</div>
