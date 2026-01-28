<?php $dbTables = array (
  'back_pages' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'id_parent',
      2 => 'name',
      3 => 'page',
      4 => 'icon',
      5 => 'is_rights',
      6 => 'help_list',
      7 => 'help_edit',
      8 => 'status',
      9 => 'ord',
    ),
    'exclude' => 
    array (
      0 => 'help_list',
      1 => 'help_edit',
    ),
  ),
  'back_settings' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'value',
      3 => 'description',
    ),
    'exclude' => 
    array (
      0 => 'value',
    ),
  ),
  'back_users' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'profile_id',
      2 => 'company_id',
      3 => 'g_id',
      4 => 'g_token',
      5 => 'fb_id',
      6 => 'fb_token',
      7 => 'ms_id',
      8 => 'ms_token',
      9 => 'pass',
      10 => 'name',
      11 => 'email',
      12 => 'status',
      13 => 'access',
      14 => 'metadata',
      15 => 'reset_key',
      16 => 'reset_expires',
    ),
    'exclude' => 
    array (
      0 => 'metadata',
    ),
  ),
  'back_users_log' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'user_id',
      2 => 'user',
      3 => 'table_',
      4 => 'type',
      5 => 'success',
      6 => 'metadata',
      7 => 'ip',
      8 => 'date',
    ),
    'exclude' => 
    array (
      0 => 'metadata',
    ),
  ),
  'back_users_logins' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'user_id',
      2 => 'user',
      3 => 'email',
      4 => 'ip',
      5 => 'date',
      6 => 'success',
      7 => 'error_code',
      8 => 'suspended_until_by_ip',
      9 => 'suspended_until_by_user',
    ),
    'exclude' => 
    array (
    ),
  ),
  'back_users_profile' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'metadata',
    ),
    'exclude' => 
    array (
      0 => 'metadata',
    ),
  ),
  'blog' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'page_id',
      2 => 'author_id',
      3 => 'title',
      4 => 'title_facebook',
      5 => 'url_key',
      6 => 'text_intro',
      7 => 'text',
      8 => 'site_title',
      9 => 'site_description',
      10 => 'site_canonical',
      11 => 'image',
      12 => 'image_timestamp',
      13 => 'image_filename',
      14 => 'image_file_ext',
      15 => 'image_filesize',
      16 => 'image_source',
      17 => 'outbound',
      18 => 'date_publish',
      19 => 'date_update',
      20 => 'metadata',
      21 => 'is_home',
      22 => 'is_evergreen',
      23 => 'is_toc',
      24 => 'is_noindex',
      25 => 'status',
    ),
    'exclude' => 
    array (
      0 => 'text',
      1 => 'metadata',
    ),
  ),
  'blog_author' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'url_key',
      3 => 'text',
      4 => 'image',
      5 => 'profile_gender',
      6 => 'profile_title',
      7 => 'profile_email',
      8 => 'profile_facebook',
      9 => 'profile_linkedin',
      10 => 'profile_instagram',
      11 => 'profile_twitter',
      12 => 'status',
    ),
    'exclude' => 
    array (
      0 => 'text',
    ),
  ),
  'blog_visit' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'blog_id',
      2 => 'ip',
      3 => 'date',
    ),
    'exclude' => 
    array (
    ),
  ),
  'blog_visit_counter' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'blog_id',
      2 => 'visits',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_404' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'link',
      2 => 'data',
      3 => 'ip',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_banner' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'title',
      2 => 'button_text',
      3 => 'link',
      4 => 'image',
      5 => 'image_mobile',
      6 => 'date_start',
      7 => 'date_end',
      8 => 'status',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_contact' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'status_id',
      2 => 'type',
      3 => 'name',
      4 => 'email',
      5 => 'phone',
      6 => 'message',
      7 => 'ip',
      8 => 'date',
      9 => 'metadata',
    ),
    'exclude' => 
    array (
      0 => 'metadata',
    ),
  ),
  'cms_list' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'type',
      2 => 'title',
      3 => 'text',
      4 => 'row_count',
      5 => 'metadata',
      6 => 'status',
      7 => 'ord',
    ),
    'exclude' => 
    array (
      0 => 'text',
      1 => 'metadata',
    ),
  ),
  'cms_list_row' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'list_id',
      2 => 'title',
      3 => 'text',
      4 => 'image',
      5 => 'image_timestamp',
      6 => 'is_home',
      7 => 'metadata',
      8 => 'status',
      9 => 'ord',
    ),
    'exclude' => 
    array (
      0 => 'text',
      1 => 'metadata',
    ),
  ),
  'cms_menu' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'parent_id',
      2 => 'page_id',
      3 => 'identifier',
      4 => 'link',
      5 => 'link_name',
      6 => 'icon',
      7 => 'is_popup',
      8 => 'ord',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_pages' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'parent_id',
      2 => 'type',
      3 => 'name',
      4 => 'url_key',
      5 => 'title',
      6 => 'text',
      7 => 'site_title',
      8 => 'site_description',
      9 => 'link_name',
      10 => 'image',
      11 => 'image_timestamp',
      12 => 'metadata',
      13 => 'is_noindex',
      14 => 'ord',
      15 => 'status',
    ),
    'exclude' => 
    array (
      0 => 'text',
      1 => 'metadata',
    ),
  ),
  'cms_redirects' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'url_from',
      2 => 'url_to',
      3 => 'redirect_type',
      4 => 'status',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_relation' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'entity',
      2 => 'entity_id',
      3 => 'module',
      4 => 'module_id',
    ),
    'exclude' => 
    array (
    ),
  ),
  'cms_various' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'type',
      3 => 'title',
      4 => 'text',
      5 => 'image',
      6 => 'image_timestamp',
      7 => 'metadata',
      8 => 'status',
    ),
    'exclude' => 
    array (
      0 => 'text',
      1 => 'metadata',
    ),
  ),
  'dsc_city' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'county_code',
      2 => 'name',
      3 => 'km',
      4 => 'date_added',
    ),
    'exclude' => 
    array (
    ),
  ),
  'dsc_county' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'code',
      3 => 'date_added',
    ),
    'exclude' => 
    array (
    ),
  ),
  'nomen_city' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'county_id',
      2 => 'siruta',
      3 => 'longitude',
      4 => 'latitude',
      5 => 'name',
      6 => 'region',
    ),
    'exclude' => 
    array (
    ),
  ),
  'nomen_county' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'area_id',
      2 => 'code',
      3 => 'name',
    ),
    'exclude' => 
    array (
    ),
  ),
  'nomen_status' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'name',
      2 => 'color',
      3 => 'ord',
    ),
    'exclude' => 
    array (
    ),
  ),
  'user_action' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'back_user_id',
      2 => 'entity_id',
      3 => 'entity_type',
    ),
    'exclude' => 
    array (
    ),
  ),
  'user_action_text' => 
  array (
    'fields' => 
    array (
      0 => 'id',
      1 => 'user_action_id',
      2 => 'back_user_id',
      3 => 'type',
      4 => 'date',
      5 => 'metadata',
    ),
    'exclude' => 
    array (
      0 => 'metadata',
    ),
  ),
); ?>