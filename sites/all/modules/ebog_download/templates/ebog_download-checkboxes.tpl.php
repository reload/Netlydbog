<div class="ebog-download-confirm">
  <p>
    <input type="checkbox" name="rule_1" id="rule_1" />
    <label for="rule_1">
      <?php print t('Yes, I do have Adobe ID') . ' (<a href="/faq/adobe-0#36n111984">' . t('read more') . '</a>).'; ?>
    </label>
  </p>
  <p>
    <input type="checkbox" name="rule_2" id="rule_2" />
    <label for="rule_2">
      <?php print t('Yes, I do have @reader installed', array('@reader' => $data['reader'])) . ' (<a href="/software">' . t('read more') . '</a>).'; ?>
    </label>
  </p>
</div>
