<?php
$viewdefs ['Campaigns'] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_TEST_BUTTON_TITLE}" accessKey="{$MOD.LBL_TEST_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\'" type="{$ADD_BUTTON_STATE}" name="button" value="{$MOD.LBL_TEST_BUTTON_LABEL}">',
          ),
          4 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_QUEUE_BUTTON_TITLE}" accessKey="{$MOD.LBL_QUEUE_BUTTON_KEY}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\'" type="{$ADD_BUTTON_STATE}" name="button" value="{$MOD.LBL_QUEUE_BUTTON_LABEL}">',
          ),
          5 => 
          array (
            'customCode' => '<input title="{$APP.LBL_MAILMERGE}" accessKey="{$APP.LBL_MAILMERGE_KEY}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'MailMerge\'" type="submit" name="button" value="{$APP.LBL_MAILMERGE}">',
          ),
          6 => 
          array (
            'customCode' => '<input title="{$MOD.LBL_MARK_AS_SENT}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\'" type="{$TARGET_BUTTON_STATE}" name="button" value="{$MOD.LBL_MARK_AS_SENT}"><input title="mode" class="button" id="mode" name="mode" type="hidden" value="">',
          ),
          7 => 
          array (
            'customCode' => '<script>{$MSG_SCRIPT}</script>',
          ),
		 8 => 
          array (
            'customCode' => '{if $fields.campaign_type.value == "SMS"}<input title="{$APP.LNK_NEW_SMS}" accessKey="{$APP.LNK_NEW_SMS}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'SendSMS\';this.form.mode.value=\'test\'" type="submit" name="button" value="{$APP.LNK_NEW_SMS}">{/if}', 
          ),         
        ),
        'links' => 
        array (
          0 => '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=WizardHome&record={$fields.id.value}\';" value="{$MOD.LBL_TO_WIZARD_TITLE}" />',
          1 => '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=TrackDetailView&record={$fields.id.value}\';" value="{$MOD.LBL_TRACK_BUTTON_LABEL}" />',
          2 => '<input type="button" class="button" onclick="javascript:window.location=\'index.php?module=Campaigns&action=RoiDetailView&record={$fields.id.value}\';" value="{$MOD.LBL_TRACK_ROI_BUTTON_LABEL}" />',
        ),
      ),
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_CAMPAIGN_NAME',
          ),
          1 => 
          array (
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'status',
            'label' => 'LBL_CAMPAIGN_STATUS',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'start_date',
            'label' => 'LBL_CAMPAIGN_START_DATE',
          ),
          1 => 
          array (
            'name' => 'modified_by_name',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}&nbsp;',
            'label' => 'LBL_DATE_MODIFIED',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'end_date',
            'label' => 'LBL_CAMPAIGN_END_DATE',
          ),
          1 => 
          array (
            'name' => 'created_by_name',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}&nbsp;',
            'label' => 'LBL_DATE_ENTERED',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'campaign_type',
            'label' => 'LBL_CAMPAIGN_TYPE',
          ),
          1 => 
          array (
            'name' => 'frequency',
            'customCode' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_field\'>{$fields.frequency.value}</div>{/if}&nbsp;',
            'customLabel' => '{if $fields.campaign_type.value == "NewsLetter"}<div style=\'none\' id=\'freq_label\'>{$MOD.LBL_CAMPAIGN_FREQUENCY}</div>{/if}&nbsp;',
            'label' => 'LBL_CAMPAIGN_FREQUENCY',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'budget',
            'label' => '{$MOD.LBL_CAMPAIGN_BUDGET} ({$CURRENCY})',
          ),
          1 => 
          array (
            'name' => 'actual_cost',
            'label' => '{$MOD.LBL_CAMPAIGN_ACTUAL_COST} ({$CURRENCY})',
          ),
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'expected_revenue',
            'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_REVENUE} ({$CURRENCY})',
          ),
          1 => 
          array (
            'name' => 'expected_cost',
            'label' => '{$MOD.LBL_CAMPAIGN_EXPECTED_COST} ({$CURRENCY})',
          ),
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'impressions',
            'label' => 'LBL_CAMPAIGN_IMPRESSIONS',
          ),
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'objective',
            'label' => 'LBL_CAMPAIGN_OBJECTIVE',
          ),
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'content',
            'label' => 'LBL_CAMPAIGN_CONTENT',
          ),
        ),
      ),
    ),
  ),
);
?>
