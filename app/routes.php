<?php
include_once 'config.inc.php';

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
  return View::make('pages.home');
});


// Sidebar
Route::get('/content/sidebar', 'SidebarController@index');

View::composer('layouts.default', function($view)
{
  $sidebar = SidebarController::getSidebar();
  // echo '<pre>'; print_r($sidebar); exit;
  $view->with('sidebar', $sidebar);
});



/* Exhibitions
*/
// Route::get('/content/exhibitions', 'ExhibitionsController@index');
// Route::get('/content/exhibitions/create',  'ExhibitionsController@create');
// Route::get('/content/exhibitions/edit/{id}', array('as' => 'exhibitions.edit', 'uses' => 'ExhibitionsController@edit'));
// Route::post('/content/exhibitions/update', array('as' => 'exhibition.update', 'uses' => 'ExhibitionsController@update'));
// Route::post('/content/exhibitions/store', array('as' => 'exhibitions.store', 'uses' => 'ExhibitionsController@store'));
// Route::post('/exhibitions/upload', 'ExhibitionsController@upload');
// Route::post('/exhibitions/save-gallery-image', 'ExhibitionsController@saveGalleryImage');
// Route::get('/exhibitions/delete-gallery-image', 'ExhibitionsController@deleteGalleryImage');
// Route::get('/exhibitions/edit-gallery-image', 'ExhibitionsController@editGalleryImage');
// Route::post('/exhibitions/update-gallery-image', 'ExhibitionsController@updateGalleryImage');
// Route::get('/content/exhibitions/delete/{id}', 'ExhibitionsController@destroy');
Route::get('/content/exhibitions', ['before' => 'auth', 'uses' => 'ExhibitionsController@index']);
Route::get('/content/exhibitions/create',  ['before' => 'auth', 'uses' => 'ExhibitionsController@create']);
Route::get('/content/exhibitions/edit/{id}', array('before' => 'auth', 'as' => 'exhibitions.edit', 'uses' => 'ExhibitionsController@edit'));
Route::post('/content/exhibitions/update', array('as' => 'exhibition.update', 'uses' => 'ExhibitionsController@update'));
Route::post('/content/exhibitions/store', array('as' => 'exhibitions.store', 'uses' => 'ExhibitionsController@store'));
Route::post('/exhibitions/upload', ['before' => 'auth', 'uses' => 'ExhibitionsController@upload']);
Route::post('/exhibitions/save-gallery-image', ['before' => 'auth', 'uses' => 'ExhibitionsController@saveGalleryImage']);
Route::get('/exhibitions/delete-gallery-image', ['before' => 'auth', 'uses' => 'ExhibitionsController@deleteGalleryImage']);
Route::get('/exhibitions/edit-gallery-image', ['before' => 'auth', 'uses' => 'ExhibitionsController@editGalleryImage']);
Route::post('/exhibitions/update-gallery-image', ['before' => 'auth', 'uses' => 'ExhibitionsController@updateGalleryImage']);
Route::get('/content/exhibitions/delete/{id}', ['before' => 'auth', 'uses' => 'ExhibitionsController@destroy']);


/* Settings
*/
// Route::get('/content/settings', 'SettingsController@index');
// Route::get('/content/settings/{id}', 'SettingsController@edit');
// Route::post('/content/settings/save', array('as' => 'settings.save', 'uses' => 'SettingsController@save'));
Route::get('/content/settings', ['before' => 'auth', 'uses' => 'SettingsController@index']);
Route::get('/content/settings/{id}', ['before' => 'auth', 'uses' => 'SettingsController@edit']);
Route::post('/content/settings/save', array('before' => 'auth', 'as' => 'settings.save', 'uses' => 'SettingsController@save'));

/* 
['before' => 'auth', 'uses' => 'ExhibitionsController@index']);
*/
/* Redirects
*/
// Route::get('/content/redirects', 'RedirectsController@index');
// Route::get('/content/redirects/create', 'RedirectsController@create');
// Route::get('/content/redirects/edit/{id}', 'RedirectsController@edit');
// Route::post('/content/redirects/save', array('as' => 'redirects.save', 'uses' => 'RedirectsController@save'));
// Route::get('/content/redirects/delete/{id}', 'RedirectsController@delete');
Route::get('/content/redirects', ['before' => 'auth', 'uses' => 'RedirectsController@index']);
Route::get('/content/redirects/create', ['before' => 'auth', 'uses' => 'RedirectsController@create']);
Route::get('/content/redirects/edit/{id}', ['before' => 'auth', 'uses' => 'RedirectsController@edit']);
Route::post('/content/redirects/save', array('before' => 'auth', 'as' => 'redirects.save', 'uses' => 'RedirectsController@save'));
Route::get('/content/redirects/delete/{id}', ['before' => 'auth', 'uses' => 'RedirectsController@delete']);

/* Clusters
*/
// Route::get('/content/clusters', 'ClustersController@index');
// Route::get('/content/clusters/create', 'ClustersController@create');
// Route::get('/content/clusters/edit/{id}', array('as' => 'cluster.edit', 'uses' => 'ClustersController@edit'));
// Route::post('/content/clusters/update', array('as' => 'cluster.update', 'uses' => 'ClustersController@update'));
// Route::post('/content/clusters/store', array('as' => 'clusters.store', 'uses' => 'ClustersController@store'));
// Route::get('/content/clusters/delete/{id}', 'ClustersController@destroy');
Route::get('/content/clusters', ['before' => 'auth', 'uses' => 'ClustersController@index']);
Route::get('/content/clusters/create', 'ClustersController@create');
Route::get('/content/clusters/edit/{id}', array('before' => 'auth', 'as' => 'cluster.edit', 'uses' => 'ClustersController@edit'));
Route::post('/content/clusters/update', array('before' => 'auth', 'as' => 'cluster.update', 'uses' => 'ClustersController@update'));
Route::post('/content/clusters/store', array('before' => 'auth', 'as' => 'clusters.store', 'uses' => 'ClustersController@store'));
Route::get('/content/clusters/delete/{id}', ['before' => 'auth', 'uses' => 'ClustersController@destroy']);

/* Tags
*/
// Route::get('/content/tags', 'TagsController@index');
// Route::get('/content/tags/create', 'TagsController@create');
// Route::get('/content/tags/edit/{id}', array('as' => 'tag.edit', 'uses' => 'TagsController@edit'));
// Route::post('/content/tags/update', array('as' => 'tag.update', 'uses' => 'TagsController@update'));
// Route::post('/content/tags/store', array('as' => 'tags.store', 'uses' => 'TagsController@store'));
// Route::get('/content/tags/delete/{id}', 'TagsController@destroy');
Route::get('/content/tags', ['before' => 'auth', 'uses' => 'TagsController@index']);
Route::get('/content/tags/create', ['before' => 'auth', 'uses' => 'TagsController@create']);
Route::get('/content/tags/edit/{id}', array('before' => 'auth', 'as' => 'tag.edit', 'uses' => 'TagsController@edit'));
Route::post('/content/tags/update', array('before' => 'auth', 'as' => 'tag.update', 'uses' => 'TagsController@update'));
Route::post('/content/tags/store', array('before' => 'auth', 'as' => 'tags.store', 'uses' => 'TagsController@store'));
Route::get('/content/tags/delete/{id}', ['before' => 'auth', 'uses' => 'TagsController@destroy']);

/* Departments
*/
// Route::get('/content/departments', 'DepartmentsController@index');
// Route::get('/departments/update-order/{id}/{order}', 'DepartmentsController@updateOrder');
// Route::get('/content/departments/create', 'DepartmentsController@create');
// Route::get('/content/departments/edit/{id}', array('as' => 'department.edit', 'uses' => 'DepartmentsController@edit'));
// Route::post('/content/departments/update', array('as' => 'department.update', 'uses' => 'DepartmentsController@update'));
// Route::post('/content/departments/store', array('as' => 'departments.store', 'uses' => 'DepartmentsController@store'));
// Route::get('/content/departments/delete/{id}', 'DepartmentsController@destroy');
Route::get('/content/departments', ['before' => 'auth', 'uses' => 'DepartmentsController@index']);
Route::get('/departments/update-order/{id}/{order}', ['before' => 'auth', 'uses' => 'DepartmentsController@updateOrder']);
Route::get('/content/departments/create', ['before' => 'auth', 'uses' => 'DepartmentsController@create']);
Route::get('/content/departments/edit/{id}', array('before' => 'auth', 'as' => 'department.edit', 'uses' => 'DepartmentsController@edit'));
Route::post('/content/departments/update', array('before' => 'auth', 'as' => 'department.update', 'uses' => 'DepartmentsController@update'));
Route::post('/content/departments/store', array('before' => 'auth', 'as' => 'departments.store', 'uses' => 'DepartmentsController@store'));
Route::get('/content/departments/delete/{id}', ['before' => 'auth', 'uses' => 'DepartmentsController@destroy']);

/* Contact
*/
// Route::get('/content/contacts', 'ContactsController@index');
// Route::get('/content/contacts/create', 'ContactsController@create');
// Route::get('/content/contacts/edit/{id}', array('as' => 'contact.edit', 'uses' => 'ContactsController@edit'));
// Route::post('/content/contacts/update', array('as' => 'contact.update', 'uses' => 'ContactsController@update'));
// Route::post('/content/contacts/store', array('as' => 'contact.store', 'uses' => 'ContactsController@store'));
// Route::get('/content/contacts/delete/{id}', 'ContactsController@destroy');
Route::get('/content/contacts', ['before' => 'auth', 'uses' => 'ContactsController@index']);
Route::get('/content/contacts/create', ['before' => 'auth', 'uses' => 'ContactsController@create']);
Route::get('/content/contacts/edit/{id}', array('before' => 'auth', 'as' => 'contact.edit', 'uses' => 'ContactsController@edit'));
Route::post('/content/contacts/update', array('before' => 'auth', 'as' => 'contact.update', 'uses' => 'ContactsController@update'));
Route::post('/content/contacts/store', array('before' => 'auth', 'as' => 'contact.store', 'uses' => 'ContactsController@store'));
Route::get('/content/contacts/delete/{id}', ['before' => 'auth', 'uses' => 'ContactsController@destroy']);

/* Sponsor Groups
*/
// Route::get('/content/sponsor-groups', 'SponsorGroupsController@index');
// Route::get('/content/sponsor-groups/create', 'SponsorGroupsController@create');
// Route::post('/sponsor-groups/save', 'SponsorGroupsController@save');
// Route::get('/content/sponsor-groups/edit/{id}', array('as' => 'sponsor_group.edit', 'uses' => 'SponsorGroupsController@edit'));
// Route::post('/content/sponsor-groups/update', array('as' => 'sponsor_group.update', 'uses' => 'SponsorGroupsController@update'));
// Route::post('/content/sponsor-groups/store', array('as' => 'sponsor_group.store', 'uses' => 'SponsorGroupsController@store'));
// Route::get('/content/sponsor-groups/delete/{id}', 'SponsorGroupsController@destroy');
// Route::post('upload-sponsor-group-logo', 'SponsorGroupsController@uploadLogo');
// Route::get('get-sponsor-group', 'SponsorGroupsController@getSponsorGroup');
// Route::get('delete-sp-group', 'SponsorGroupsController@deleteSponsorGroup');
Route::get('/content/sponsor-groups', ['before' => 'auth', 'uses' => 'SponsorGroupsController@index']);
Route::get('/content/sponsor-groups/create', ['before' => 'auth', 'uses' => 'SponsorGroupsController@create']);
Route::post('/sponsor-groups/save', ['before' => 'auth', 'uses' => 'SponsorGroupsController@save']);
Route::get('/content/sponsor-groups/edit/{id}', array('before' => 'auth', 'as' => 'sponsor_group.edit', 'uses' => 'SponsorGroupsController@edit'));
Route::post('/content/sponsor-groups/update', array('before' => 'auth', 'as' => 'sponsor_group.update', 'uses' => 'SponsorGroupsController@update'));
Route::post('/content/sponsor-groups/store', array('before' => 'auth', 'as' => 'sponsor_group.store', 'uses' => 'SponsorGroupsController@store'));
Route::get('/content/sponsor-groups/delete/{id}', ['before' => 'auth', 'uses' => 'SponsorGroupsController@destroy']);
Route::post('upload-sponsor-group-logo', ['before' => 'auth', 'uses' => 'SponsorGroupsController@uploadLogo']);
Route::get('get-sponsor-group', ['before' => 'auth', 'uses' => 'SponsorGroupsController@getSponsorGroup']);
Route::get('delete-sp-group', ['before' => 'auth', 'uses' => 'SponsorGroupsController@deleteSponsorGroup']);

// Exb
// Route::get('/content/exb-sponsor-groups', 'SponsorGroupsExbController@index');
// Route::get('/content/exb-sponsor-groups/create', 'SponsorGroupsExbController@create');
// Route::post('/exb-sponsor-groups/save', 'SponsorGroupsExbController@save');
// Route::get('/content/exb-sponsor-groups/edit/{id}', array('as' => 'exb_sponsor_group.edit', 'uses' => 'SponsorGroupsExbController@edit'));
// Route::post('/content/exb-sponsor-groups/update', array('as' => 'exb_sponsor_group.update', 'uses' => 'SponsorGroupsExbController@update'));
// Route::post('/content/exb-sponsor-groups/store', array('as' => 'exb_sponsor_group.store', 'uses' => 'SponsorGroupsExbController@store'));
// Route::get('/content/sponsor-groups/delete/{id}', 'SponsorGroupsExbController@destroy');
// Route::post('upload-exb-sponsor-group-logo', 'SponsorGroupsExbController@uploadLogo');
// Route::get('get-exb-sponsor-group', 'SponsorGroupsExbController@getSponsorGroup');
// Route::get('delete-exb-sp-group', 'SponsorGroupsExbController@deleteSponsorGroup');
Route::get('/content/exb-sponsor-groups', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@index']);
Route::get('/content/exb-sponsor-groups/create', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@create']);
Route::post('/exb-sponsor-groups/save', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@save']);
Route::get('/content/exb-sponsor-groups/edit/{id}', array('before' => 'auth', 'as' => 'exb_sponsor_group.edit', 'uses' => 'SponsorGroupsExbController@edit'));
Route::post('/content/exb-sponsor-groups/update', array('before' => 'auth', 'as' => 'exb_sponsor_group.update', 'uses' => 'SponsorGroupsExbController@update'));
Route::post('/content/exb-sponsor-groups/store', array('before' => 'auth', 'as' => 'exb_sponsor_group.store', 'uses' => 'SponsorGroupsExbController@store'));
Route::get('/content/sponsor-groups/delete/{id}', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@destroy']);
Route::post('upload-exb-sponsor-group-logo', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@uploadLogo']);
Route::get('get-exb-sponsor-group', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@getSponsorGroup']);
Route::get('delete-exb-sp-group', ['before' => 'auth', 'uses' => 'SponsorGroupsExbController@deleteSponsorGroup']);


/* Sponsors
*/
// Route::get('/content/sponsors', 'SponsorsController@index');
// Route::post('/sponsors/save', 'SponsorsController@save');
// Route::get('/content/sponsors/create', 'SponsorsController@create');
// Route::get('/content/sponsors/edit/{id}', array('as' => 'sponsor.edit', 'uses' => 'SponsorsController@edit'));
// Route::post('/content/sponsors/update', array('as' => 'sponsor.update', 'uses' => 'SponsorsController@update'));
// Route::post('/content/sponsors/store', array('as' => 'sponsor.store', 'uses' => 'SponsorsController@store'));
// Route::get('/content/sponsors/delete/{id}', 'SponsorsController@destroy');
// Route::post('upload-sponsor-logo', 'SponsorsController@uploadLogo');
// Route::get('delete-sponsor', 'SponsorsController@deleteSponsor');
// Route::get('get-sponsor', 'SponsorsController@getSponsor');
Route::get('/content/sponsors', ['before' => 'auth', 'uses' => 'SponsorsController@index']);
Route::post('/sponsors/save', ['before' => 'auth', 'uses' => 'SponsorsController@save']);
Route::get('/content/sponsors/create', ['before' => 'auth', 'uses' => 'SponsorsController@create']);
Route::get('/content/sponsors/edit/{id}', array('before' => 'auth', 'as' => 'sponsor.edit', 'uses' => 'SponsorsController@edit'));
Route::post('/content/sponsors/update', array('before' => 'auth', 'as' => 'sponsor.update', 'uses' => 'SponsorsController@update'));
Route::post('/content/sponsors/store', array('before' => 'auth', 'as' => 'sponsor.store', 'uses' => 'SponsorsController@store'));
Route::get('/content/sponsors/delete/{id}', ['before' => 'auth', 'uses' => 'SponsorsController@destroy']);
Route::post('upload-sponsor-logo', ['before' => 'auth', 'uses' => 'SponsorsController@uploadLogo']);
Route::get('delete-sponsor', ['before' => 'auth', 'uses' => 'SponsorsController@deleteSponsor']);
Route::get('get-sponsor', ['before' => 'auth', 'uses' => 'SponsorsController@getSponsor']);

// Exb
// Route::get('/content/exb-sponsors', 'SponsorsExbController@index');
// Route::post('/exb-sponsors/save', 'SponsorsExbController@save');
// Route::get('/content/exb-sponsors/create', 'SponsorsExbController@create');
// Route::get('/content/exb-sponsors/edit/{id}', array('as' => 'exb-sponsor.edit', 'uses' => 'SponsorsExbController@edit'));
// Route::post('/content/exb-sponsors/update', array('as' => 'exb-sponsor.update', 'uses' => 'SponsorsExbController@update'));
// Route::post('/content/exb-sponsors/store', array('as' => 'exb-sponsor.store', 'uses' => 'SponsorsExbController@store'));
// Route::get('/content/exb-sponsors/delete/{id}', 'SponsorsExbController@destroy');
// Route::post('upload-exb-sponsor-logo', 'SponsorsExbController@uploadLogo');
// Route::get('delete-exb-sponsor', 'SponsorsExbController@deleteSponsor');
// Route::get('get-exb-sponsor', 'SponsorsExbController@getSponsor');
Route::get('/content/exb-sponsors', ['before' => 'auth', 'uses' => 'SponsorsExbController@index']);
Route::post('/exb-sponsors/save', ['before' => 'auth', 'uses' => 'SponsorsExbController@save']);
Route::get('/content/exb-sponsors/create', ['before' => 'auth', 'uses' => 'SponsorsExbController@create']);
Route::get('/content/exb-sponsors/edit/{id}', array('before' => 'auth', 'as' => 'exb-sponsor.edit', 'uses' => 'SponsorsExbController@edit'));
Route::post('/content/exb-sponsors/update', array('before' => 'auth', 'as' => 'exb-sponsor.update', 'uses' => 'SponsorsExbController@update'));
Route::post('/content/exb-sponsors/store', array('before' => 'auth', 'as' => 'exb-sponsor.store', 'uses' => 'SponsorsExbController@store'));
Route::get('/content/exb-sponsors/delete/{id}', ['before' => 'auth', 'uses' => 'SponsorsExbController@destroy']);
Route::post('upload-exb-sponsor-logo', ['before' => 'auth', 'uses' => 'SponsorsExbController@uploadLogo']);
Route::get('delete-exb-sponsor', ['before' => 'auth', 'uses' => 'SponsorsExbController@deleteSponsor']);
Route::get('get-exb-sponsor', ['before' => 'auth', 'uses' => 'SponsorsExbController@getSponsor']);


/* Downloads
*/
// Route::get('/content/downloads', 'DownloadsController@index');
// Route::post('/downloads/save', 'DownloadsController@save');
// Route::get('/content/downloads/create', 'DownloadsController@create');
// Route::get('/content/downloads/edit/{id}', array('as' => 'download.edit', 'uses' => 'DownloadsController@edit'));
// Route::post('/content/downloads/update', array('as' => 'download.update', 'uses' => 'DownloadsController@update'));
// Route::post('/content/downloads/store', array('as' => 'download.store', 'uses' => 'DownloadsController@store'));
// Route::get('/content/downloads/delete/{id}', 'DownloadsController@destroy');
// Route::post('upload-download-file', 'DownloadsController@uploadDownloadFile');
// Route::get('delete-download', 'DownloadsController@deleteDownload');
// Route::get('delete-dl-terms-file', 'PagesController@deleteDLTermsFile');
// Route::get('get-download', 'DownloadsController@getDownload');
// Route::post('upload-thumb-file', 'DownloadsController@uploadThumb');

// Route::post('save-dl-protection', 'PagesController@saveDLProtection');
Route::get('/content/downloads', ['before' => 'auth', 'uses' => 'DownloadsController@index']);
Route::post('/downloads/save', ['before' => 'auth', 'uses' => 'DownloadsController@save']);
Route::get('/content/downloads/create', ['before' => 'auth', 'uses' => 'DownloadsController@create']);
Route::get('/content/downloads/edit/{id}', array('before' => 'auth', 'as' => 'download.edit', 'uses' => 'DownloadsController@edit'));
Route::post('/content/downloads/update', array('before' => 'auth', 'as' => 'download.update', 'uses' => 'DownloadsController@update'));
Route::post('/content/downloads/store', array('before' => 'auth', 'as' => 'download.store', 'uses' => 'DownloadsController@store'));
Route::get('/content/downloads/delete/{id}', ['before' => 'auth', 'uses' => 'DownloadsController@destroy']);
Route::post('upload-download-file', ['before' => 'auth', 'uses' => 'DownloadsController@uploadDownloadFile']);
Route::get('delete-download', ['before' => 'auth', 'uses' => 'DownloadsController@deleteDownload']);
Route::get('delete-dl-terms-file', ['before' => 'auth', 'uses' => 'PagesController@deleteDLTermsFile']);
Route::get('get-download', ['before' => 'auth', 'uses' => 'DownloadsController@getDownload']);
Route::post('upload-thumb-file', ['before' => 'auth', 'uses' => 'DownloadsController@uploadThumb']);

Route::post('save-dl-protection', ['before' => 'auth', 'uses' => 'PagesController@saveDLProtection']);

// Exb
// Route::get('/content/exb-downloads', 'DownloadsExbController@index');
// Route::post('/exb-downloads/save', 'DownloadsExbController@save');
// Route::get('/content/exb-downloads/create', 'DownloadsExbController@create');
// Route::get('/content/exb-downloads/edit/{id}', array('as' => 'exb-download.edit', 'uses' => 'DownloadsExbController@edit'));
// Route::post('/content/exb-downloads/update', array('as' => 'exb-download.update', 'uses' => 'DownloadsExbController@update'));
// Route::post('/content/exb-downloads/store', array('as' => 'exb-download.store', 'uses' => 'DownloadsExbController@store'));
// Route::get('/content/exb-downloads/delete/{id}', 'DownloadsExbController@destroy');
Route::get('/content/exb-downloads', ['before' => 'auth', 'uses' => 'DownloadsExbController@index']);
Route::post('/exb-downloads/save', ['before' => 'auth', 'uses' => 'DownloadsExbController@save']);
Route::get('/content/exb-downloads/create', ['before' => 'auth', 'uses' => 'DownloadsExbController@create']);
Route::get('/content/exb-downloads/edit/{id}', array('before' => 'auth', 'as' => 'exb-download.edit', 'uses' => 'DownloadsExbController@edit'));
Route::post('/content/exb-downloads/update', array('before' => 'auth', 'as' => 'exb-download.update', 'uses' => 'DownloadsExbController@update'));
Route::post('/content/exb-downloads/store', array('before' => 'auth', 'as' => 'exb-download.store', 'uses' => 'DownloadsExbController@store'));
Route::get('/content/exb-downloads/delete/{id}', ['before' => 'auth', 'uses' => 'DownloadsExbController@destroy']);


/* Teaser
*/
// Route::get('/content/teasers', 'TeasersController@index');
// Route::post('/teasers/save', 'TeasersController@save');
// Route::get('/content/teasers/create', 'TeasersController@create');
// Route::get('/content/teasers/edit/{id}', array('as' => 'teaser.edit', 'uses' => 'TeasersController@edit'));
// Route::post('/content/teasers/update', array('as' => 'teaser.update', 'uses' => 'TeasersController@update'));
// Route::post('/content/teasers/store', array('as' => 'teaser.store', 'uses' => 'TeasersController@store'));
// Route::get('/content/teasers/delete/{id}', 'TeasersController@destroy');
// Route::post('upload-teaser', 'TeasersController@uploadTeaser');
// Route::get('delete-teaser', 'TeasersController@deleteTeaser');
// Route::get('get-teaser', 'TeasersController@getTeaser');
Route::get('/content/teasers', ['before' => 'auth', 'uses' => 'TeasersController@index']);
Route::post('/teasers/save', ['before' => 'auth', 'uses' => 'TeasersController@save']);
Route::get('/content/teasers/create', ['before' => 'auth', 'uses' => 'TeasersController@create']);
Route::get('/content/teasers/edit/{id}', array('before' => 'auth', 'as' => 'teaser.edit', 'uses' => 'TeasersController@edit'));
Route::post('/content/teasers/update', array('before' => 'auth', 'as' => 'teaser.update', 'uses' => 'TeasersController@update'));
Route::post('/content/teasers/store', array('before' => 'auth', 'as' => 'teaser.store', 'uses' => 'TeasersController@store'));
Route::get('/content/teasers/delete/{id}', ['before' => 'auth', 'uses' => 'TeasersController@destroy']);
Route::post('upload-teaser', ['before' => 'auth', 'uses' => 'TeasersController@uploadTeaser']);
Route::get('delete-teaser', ['before' => 'auth', 'uses' => 'TeasersController@deleteTeaser']);
Route::get('get-teaser', ['before' => 'auth', 'uses' => 'TeasersController@getTeaser']);
// Exb
// Route::get('/content/exb-teasers', 'TeasersExbController@index');
// Route::post('/exb-teasers/save', 'TeasersExbController@save');
// Route::get('/content/exb-teasers/create', 'TeasersExbController@create');
// Route::get('/content/exb-teasers/edit/{id}', array('as' => 'teaser.edit', 'uses' => 'TeasersExbController@edit'));
// Route::post('/content/exb-teasers/update', array('as' => 'teaser.update', 'uses' => 'TeasersExbController@update'));
// Route::post('/content/exb-teasers/store', array('as' => 'teaser.store', 'uses' => 'TeasersExbController@store'));
// Route::get('/content/exb-teasers/delete/{id}', 'TeasersExbController@destroy');
// Route::post('upload-exb-teaser', 'TeasersExbController@uploadTeaser');
// Route::get('delete-exb-teaser', 'TeasersExbController@deleteTeaser');
// Route::get('get-exb-teaser', 'TeasersExbController@getTeaser');
Route::get('/content/exb-teasers', ['before' => 'auth', 'uses' => 'TeasersExbController@index']);
Route::post('/exb-teasers/save', ['before' => 'auth', 'uses' => 'TeasersExbController@save']);
Route::get('/content/exb-teasers/create', ['before' => 'auth', 'uses' => 'TeasersExbController@create']);
Route::get('/content/exb-teasers/edit/{id}', array('before' => 'auth', 'as' => 'teaser.edit', 'uses' => 'TeasersExbController@edit'));
Route::post('/content/exb-teasers/update', array('before' => 'auth', 'as' => 'teaser.update', 'uses' => 'TeasersExbController@update'));
Route::post('/content/exb-teasers/store', array('before' => 'auth', 'as' => 'teaser.store', 'uses' => 'TeasersExbController@store'));
Route::get('/content/exb-teasers/delete/{id}', ['before' => 'auth', 'uses' => 'TeasersExbController@destroy']);
Route::post('upload-exb-teaser', ['before' => 'auth', 'uses' => 'TeasersExbController@uploadTeaser']);
Route::get('delete-exb-teaser', ['before' => 'auth', 'uses' => 'TeasersExbController@deleteTeaser']);
Route::get('get-exb-teaser', ['before' => 'auth', 'uses' => 'TeasersExbController@getTeaser']);


/* Event Clusters
*/
// Route::get('/content/event_clusters', 'EventClustersController@index');
// Route::get('/content/event_clusters/create', 'EventClustersController@create'); // function() { return View::make('pages.clusters.create'); });
// Route::get('/content/event_clusters/edit/{id}', array('as' => 'event_cluster.edit', 'uses' => 'EventClustersController@edit'));
// Route::post('/content/event_clusters/update', array('as' => 'event_cluster.update', 'uses' => 'EventClustersController@update'));
// Route::post('/content/event_clusters/store', array('as' => 'event_clusters.store', 'uses' => 'EventClustersController@store'));
// Route::get('/content/event_clusters/delete/{id}', 'EventClustersController@destroy');
Route::get('/content/event_clusters', ['before' => 'auth', 'uses' => 'EventClustersController@index']);
Route::get('/content/event_clusters/create', ['before' => 'auth', 'uses' => 'EventClustersController@create']);
Route::get('/content/event_clusters/edit/{id}', array('before' => 'auth', 'as' => 'event_cluster.edit', 'uses' => 'EventClustersController@edit'));
Route::post('/content/event_clusters/update', array('before' => 'auth', 'as' => 'event_cluster.update', 'uses' => 'EventClustersController@update'));
Route::post('/content/event_clusters/store', array('before' => 'auth', 'as' => 'event_clusters.store', 'uses' => 'EventClustersController@store'));
Route::get('/content/event_clusters/delete/{id}', ['before' => 'auth', 'uses' => 'EventClustersController@destroy']);

/* Exhibition Clusters
*/
// Route::get('/content/exhibition_clusters', 'ExhibitionClustersController@index');
// Route::get('/content/exhibition_clusters/create', 'ExhibitionClustersController@create');
// Route::get('/content/exhibition_clusters/edit/{id}', array('as' => 'exhibition_cluster.edit', 'uses' => 'ExhibitionClustersController@edit'));
// Route::post('/content/exhibition_clusters/update', array('as' => 'exhibition_cluster.update', 'uses' => 'ExhibitionClustersController@update'));
// Route::post('/content/exhibition_clusters/store', array('as' => 'exhibition_clusters.store', 'uses' => 'ExhibitionClustersController@store'));
// Route::get('/content/exhibition_clusters/delete/{id}', 'ExhibitionClustersController@destroy');
Route::get('/content/exhibition_clusters', ['before' => 'auth', 'uses' => 'ExhibitionClustersController@index']);
Route::get('/content/exhibition_clusters/create', ['before' => 'auth', 'uses' => 'ExhibitionClustersController@create']);
Route::get('/content/exhibition_clusters/edit/{id}', array('before' => 'auth', 'as' => 'exhibition_cluster.edit', 'uses' => 'ExhibitionClustersController@edit'));
Route::post('/content/exhibition_clusters/update', array('before' => 'auth', 'as' => 'exhibition_cluster.update', 'uses' => 'ExhibitionClustersController@update'));
Route::post('/content/exhibition_clusters/store', array('before' => 'auth', 'as' => 'exhibition_clusters.store', 'uses' => 'ExhibitionClustersController@store'));
Route::get('/content/exhibition_clusters/delete/{id}', ['before' => 'auth', 'uses' => 'ExhibitionClustersController@destroy']);

/* Main Menu
*/
// Route::get('/content/menu-items', 'MenuItemsController@index');
// Route::get('/menu-items/update-sort/{id}/{order}', 'MenuItemsController@updateSort');
// Route::get('/content/menu-items/create', 'MenuItemsController@create');
// Route::get('/content/menu-items/edit/{id}', array('as' => 'menu_items.edit', 'uses' => 'MenuItemsController@edit'));
// Route::post('/content/menu-items/update', array('as' => 'menu_items.update', 'uses' => 'MenuItemsController@update'));
// Route::post('/content/menu-items/store', array('as' => 'menu_items.store', 'uses' => 'MenuItemsController@store'));
// Route::get('/content/menu-items/delete/{id}', 'MenuItemsController@destroy');
Route::get('/content/menu-items', ['before' => 'auth', 'uses' => 'MenuItemsController@index']);
Route::get('/menu-items/update-sort/{id}/{order}', ['before' => 'auth', 'uses' => 'MenuItemsController@updateSort']);
Route::get('/content/menu-items/create', ['before' => 'auth', 'uses' => 'MenuItemsController@create']);
Route::get('/content/menu-items/edit/{id}', array('before' => 'auth', 'as' => 'menu_items.edit', 'uses' => 'MenuItemsController@edit'));
Route::post('/content/menu-items/update', array('before' => 'auth', 'as' => 'menu_items.update', 'uses' => 'MenuItemsController@update'));
Route::post('/content/menu-items/store', array('before' => 'auth', 'as' => 'menu_items.store', 'uses' => 'MenuItemsController@store'));
Route::get('/content/menu-items/delete/{id}', ['before' => 'auth', 'uses' => 'MenuItemsController@destroy']);

/* Content Sections
*/
// Route::get('/content/content-sections/{menu_item_id}', 'ContentSectionsController@index');
// Route::get('/content/content-sections/create/{menu_item_id}', 'ContentSectionsController@create');
// Route::get('/content/content-sections/edit/{menu_item_id}/{id}', array('as' => 'content_sections.edit', 'uses' => 'ContentSectionsController@edit'));
// Route::post('/content/content-sections/update', array('as' => 'content_sections.update', 'uses' => 'ContentSectionsController@update'));
// Route::post('/content/content-sections/store', array('as' => 'content_sections.store', 'uses' => 'ContentSectionsController@store'));
// Route::get('/content-sections/delete/{menu_item_id}/{id}', 'ContentSectionsController@destroy');
// Route::get('/content-sections/update-sort/{id}/{order}', 'ContentSectionsController@updateSort');
Route::get('/content/content-sections/{menu_item_id}', ['before' => 'auth', 'uses' => 'ContentSectionsController@index']);
Route::get('/content/content-sections/create/{menu_item_id}', ['before' => 'auth', 'uses' => 'ContentSectionsController@create']);
Route::get('/content/content-sections/edit/{menu_item_id}/{id}', array('before' => 'auth', 'as' => 'content_sections.edit', 'uses' => 'ContentSectionsController@edit'));
Route::post('/content/content-sections/update', array('before' => 'auth', 'as' => 'content_sections.update', 'uses' => 'ContentSectionsController@update'));
Route::post('/content/content-sections/store', array('before' => 'auth', 'as' => 'content_sections.store', 'uses' => 'ContentSectionsController@store'));
Route::get('/content-sections/delete/{menu_item_id}/{id}', ['before' => 'auth', 'uses' => 'ContentSectionsController@destroy']);
Route::get('/content-sections/update-sort/{id}/{order}', ['before' => 'auth', 'uses' => 'ContentSectionsController@updateSort']);

/* Pages
*/
// Route::get('/content/pages/{menu_item_id}/{cs_id}', 'PagesController@index');
// Route::post('/pages/set-order', 'PagesController@setPageOrder');
// Route::get('/pages/set-main-teaser/{page_id}/{menu_item_id}/{cs_id}', 'PagesController@setMainTeaser');
// Route::get('/pages/unset-main-teaser/{page_id}/{menu_item_id}/{cs_id}', 'PagesController@unsetMainTeaser');
// //Route::get('/content/pages/create', 'PagesController@create');
// Route::get('/content/content-sections/create-sp/{menu_item_id}', 'ContentSectionsController@createSinglePage');
// Route::get('/content/pages/create-sp/{menu_item_id}/{cs_id}', 'PagesController@createSectionPage');
// Route::get('/content/pages/edit/{menu_item_id}/{cs_id}/{id}/{action?}', array('as' => 'pages.edit', 'uses' => 'PagesController@edit'));
// Route::get('/content/pages/edit-sp/{menu_item_id}/{cs_id}/{id}', array('as' => 'pages.edit-sp', 'uses' => 'PagesController@editSectionPage'));
// Route::get('/content/pages/preview/{cs_id}/{id}', array('as' => 'pages.edit', 'uses' => 'PagesController@preview'));
// Route::post('/content/pages/update', array('as' => 'pages.update', 'uses' => 'PagesController@update'));
// Route::post('/content/pages/update-sp', array('as' => 'pages.update-sp', 'uses' => 'PagesController@updateSectionPage'));
// Route::post('/content/pages/store', array('as' => 'pages.store', 'uses' => 'PagesController@store'));
// Route::post('/content/pages/store-sp', array('as' => 'pages.store-sp', 'uses' => 'PagesController@storeSinglePage'));
// Route::get('/content/pages/delete/{menu_item_id}/{cs_id}/{id}', 'PagesController@destroy');
// Route::post('upload-page-image', 'PagesController@uploadPageImage');
// Route::post('save-page-image', 'PagesController@saveBanner');
// Route::post('/content/pages/saveBanner', array('as' => 'page.image.save', 'uses' => 'PagesController@saveBanner'));
// Route::get('delete-page-image', 'PagesController@deletePageImage');
// Route::get('/content/pages/delete-page/{menu_item_id}/{cs_id}/{page_id}', 'PagesController@deletePage');
// Route::get('get-banner', 'PagesController@getBanner');
// Route::get('delete-banner', 'PagesController@deleteBanner');
Route::get('delete-exb-dl-terms-file', 'PagesController@deleteDLTermsFile');
// Route::post('save-banner', 'PagesController@saveBanner');
// Route::post('/save-page-dl-protection', 'PagesController@saveDLProtection');
// Route::get('/reset-dl-protection', 'PagesController@resetDLProtection');
// Route::get('/delete-page-dl-terms-file', 'PagesController@deleteDLTermsFile');
Route::get('/content/pages/{menu_item_id}/{cs_id}', ['before' => 'auth', 'uses' => 'PagesController@index']);
Route::post('/pages/set-order', ['before' => 'auth', 'uses' => 'PagesController@setPageOrder']);
Route::get('/pages/set-main-teaser/{page_id}/{menu_item_id}/{cs_id}', ['before' => 'auth', 'uses' => 'PagesController@setMainTeaser']);
Route::get('/pages/unset-main-teaser/{page_id}/{menu_item_id}/{cs_id}', ['before' => 'auth', 'uses' => 'PagesController@unsetMainTeaser']);
Route::get('/content/content-sections/create-sp/{menu_item_id}', ['before' => 'auth', 'uses' => 'ContentSectionsController@createSinglePage']);
Route::get('/content/pages/create-sp/{menu_item_id}/{cs_id}', ['before' => 'auth', 'uses' => 'PagesController@createSectionPage']);
Route::get('/content/pages/edit/{menu_item_id}/{cs_id}/{id}/{action?}', array('before' => 'auth', 'as' => 'pages.edit', 'uses' => 'PagesController@edit'));
Route::get('/content/pages/edit-sp/{menu_item_id}/{cs_id}/{id}', array('before' => 'auth', 'as' => 'pages.edit-sp', 'uses' => 'PagesController@editSectionPage'));
Route::get('/content/pages/preview/{cs_id}/{id}', array('before' => 'auth', 'as' => 'pages.edit', 'uses' => 'PagesController@preview'));
Route::post('/content/pages/update', array('before' => 'auth', 'as' => 'pages.update', 'uses' => 'PagesController@update'));
Route::post('/content/pages/update-sp', array('before' => 'auth', 'as' => 'pages.update-sp', 'uses' => 'PagesController@updateSectionPage'));
Route::post('/content/pages/store', array('before' => 'auth', 'as' => 'pages.store', 'uses' => 'PagesController@store'));
Route::post('/content/pages/store-sp', array('before' => 'auth', 'as' => 'pages.store-sp', 'uses' => 'PagesController@storeSinglePage'));
Route::get('/content/pages/delete/{menu_item_id}/{cs_id}/{id}', ['before' => 'auth', 'uses' => 'PagesController@destroy']);
Route::post('upload-page-image', ['before' => 'auth', 'uses' => 'PagesController@uploadPageImage']);
Route::post('save-page-image', ['before' => 'auth', 'uses' => 'PagesController@saveBanner']);
Route::post('/content/pages/saveBanner', array('before' => 'auth', 'as' => 'page.image.save', 'uses' => 'PagesController@saveBanner'));
Route::get('delete-page-image', ['before' => 'auth', 'uses' => 'PagesController@deletePageImage']);
Route::get('/content/pages/delete-page/{menu_item_id}/{cs_id}/{page_id}', ['before' => 'auth', 'uses' => 'PagesController@deletePage']);
Route::get('get-banner', ['before' => 'auth', 'uses' => 'PagesController@getBanner']);
Route::get('delete-banner', ['before' => 'auth', 'uses' => 'PagesController@deleteBanner']);
Route::post('save-banner', ['before' => 'auth', 'uses' => 'PagesController@saveBanner']);
Route::post('/save-page-dl-protection', ['before' => 'auth', 'uses' => 'PagesController@saveDLProtection']);
Route::get('/reset-dl-protection', ['before' => 'auth', 'uses' => 'PagesController@resetDLProtection']);
Route::get('/delete-page-dl-terms-file', ['before' => 'auth', 'uses' => 'PagesController@deleteDLTermsFile']);

/* Start Page
*/
// Route::get('/pages/edit-start-page', 'PagesController@editStartPage');
// Route::post('/pages/save-start-page', array('as' => 'start-page.save', 'uses' => 'PagesController@saveStartPage'));
// Route::get('get-slide', 'ExhibitionPagesController@getSlide');
// Route::get('delete-slide', 'ExhibitionPagesController@deleteSlide');
// Route::post('save-slide', 'ExhibitionPagesController@saveSlide');
// Route::get('get-slide-text', 'PagesController@getSlideText');
// Route::get('delete-slide-text', 'PagesController@deleteSlideText');
// Route::post('save-slide-text', 'PagesController@saveSlideText');
Route::get('/pages/edit-start-page', ['before' => 'auth', 'uses' => 'PagesController@editStartPage']);
Route::post('/pages/save-start-page', array('before' => 'auth', 'as' => 'start-page.save', 'uses' => 'PagesController@saveStartPage'));
Route::get('get-slide', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@getSlide']);
Route::get('delete-slide', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deleteSlide']);
Route::post('save-slide', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@saveSlide']);
Route::get('get-slide-text', ['before' => 'auth', 'uses' => 'PagesController@getSlideText']);
Route::get('delete-slide-text', ['before' => 'auth', 'uses' => 'PagesController@deleteSlideText']);
Route::post('save-slide-text', ['before' => 'auth', 'uses' => 'PagesController@saveSlideText']);

// set slide order ... start page
// Route::get('/page-slider-images/set-slide-order/{id}/{order}', 'PageSliderImagesController@setSlideOrder');
Route::get('/page-slider-images/set-slide-order/{id}/{order}', ['before' => 'auth', 'uses' => 'PageSliderImagesController@setSlideOrder']);


/* Footer Pages
*/
// Route::get('/content/footer-pages', 'FooterPagesController@index');
// Route::get('/content/pages/create-ftr-page', 'FooterPagesController@create');
// Route::get('/content/footer-pages/edit/{id}/{action?}', array('as' => 'ftr-pages.edit', 'uses' => 'FooterPagesController@edit'));
// Route::get('/content/footer-pages/preview/{id}', array('as' => 'ftr-pages.edit', 'uses' => 'FooterPagesController@preview'));
// Route::post('/content/footer-pages/update', array('as' => 'ftr-pages.update', 'uses' => 'FooterPagesController@update'));
// Route::post('/content/footer-pages/store', array('as' => 'ftr-pages.store', 'uses' => 'FooterPagesController@store'));
// Route::post('/content/footer-pages/save', array('as' => 'ftr-pages.save', 'uses' => 'FooterPagesController@save'));
// Route::get('/content/footer-pages/delete/{id}', 'FooterPagesController@destroy');
// Route::post('upload-ftr-page-image', 'FooterPagesController@uploadFooterPageImage');
// Route::post('save-page-image', 'FooterPagesController@saveBanner');
// Route::post('/content/footer-pages/saveBanner', array('as' => 'ftr-page.image.save', 'uses' => 'FooterPagesController@saveBanner'));
// Route::get('delete-page-image', 'FooterPagesController@deletePageImage');
// Route::get('get-banner', 'FooterPagesController@getBanner');
// Route::get('delete-banner', 'FooterPagesController@deleteBanner');
// Route::post('save-banner', 'FooterPagesController@saveBanner');
// Route::post('/save-ftr-dl-protection', 'FooterPagesController@saveDLProtection');
// Route::get('/reset-ftr-dl-protection', 'FooterPagesController@resetDLProtection');
// Route::get('/delete-ftr-dl-terms-file', 'FooterPagesController@deleteDLTermsFile');
Route::get('/content/footer-pages', ['before' => 'auth', 'uses' => 'FooterPagesController@index']);
Route::get('/content/pages/create-ftr-page', ['before' => 'auth', 'uses' => 'FooterPagesController@create']);
Route::get('/content/footer-pages/edit/{id}/{action?}', array('before' => 'auth', 'as' => 'ftr-pages.edit', 'uses' => 'FooterPagesController@edit'));
Route::get('/content/footer-pages/preview/{id}', array('before' => 'auth', 'as' => 'ftr-pages.edit', 'uses' => 'FooterPagesController@preview'));
Route::post('/content/footer-pages/update', array('before' => 'auth', 'as' => 'ftr-pages.update', 'uses' => 'FooterPagesController@update'));
Route::post('/content/footer-pages/store', array('before' => 'auth', 'as' => 'ftr-pages.store', 'uses' => 'FooterPagesController@store'));
Route::post('/content/footer-pages/save', array('before' => 'auth', 'as' => 'ftr-pages.save', 'uses' => 'FooterPagesController@save'));
Route::get('/content/footer-pages/delete/{id}', ['before' => 'auth', 'uses' => 'FooterPagesController@destroy']);
Route::post('upload-ftr-page-image', ['before' => 'auth', 'uses' => 'FooterPagesController@uploadFooterPageImage']);
Route::post('save-page-image', ['before' => 'auth', 'uses' => 'FooterPagesController@saveBanner']);
Route::post('/content/footer-pages/saveBanner', array('before' => 'auth', 'as' => 'ftr-page.image.save', 'uses' => 'FooterPagesController@saveBanner'));
Route::get('delete-page-image', ['before' => 'auth', 'uses' => 'FooterPagesController@deletePageImage']);
Route::get('get-banner', ['before' => 'auth', 'uses' => 'FooterPagesController@getBanner']);
// Route::get('delete-banner', ['before' => 'auth', 'uses' => 'FooterPagesController@deleteBanner']);
Route::post('save-banner', ['before' => 'auth', 'uses' => 'FooterPagesController@saveBanner']);
Route::post('/save-ftr-dl-protection', ['before' => 'auth', 'uses' => 'FooterPagesController@saveDLProtection']);
Route::get('/reset-ftr-dl-protection', ['before' => 'auth', 'uses' => 'FooterPagesController@resetDLProtection']);
Route::get('/delete-ftr-dl-terms-file', ['before' => 'auth', 'uses' => 'FooterPagesController@deleteDLTermsFile']);


/* Exhibition Pages
*/
// Route::get('/content/exhibition-pages', 'ExhibitionPagesController@index');
// Route::get('/content/pages/create-exb-page', 'ExhibitionPagesController@create');
// Route::get('/content/exhibition-pages/edit/{id}/{action?}', array('as' => 'exb-pages.edit', 'uses' => 'ExhibitionPagesController@edit'));
// Route::get('/content/exhibition-pages/preview/{id}', array('as' => 'exb-pages.edit', 'uses' => 'ExhibitionPagesController@preview'));
// Route::post('/content/exhibition-pages/update', array('as' => 'exb-pages.update', 'uses' => 'ExhibitionPagesController@update'));
// Route::post('/content/exhibition-pages/store', array('as' => 'exb-pages.store', 'uses' => 'ExhibitionPagesController@store'));
// Route::post('/content/exhibition-pages/save', array('as' => 'exb-pages.save', 'uses' => 'ExhibitionPagesController@save'));
// Route::get('/content/exhibition-pages/delete/{id}', 'ExhibitionPagesController@destroy');
// Route::post('upload-exb-page-image', 'ExhibitionPagesController@uploadExhibitionPageImage');
// Route::post('save-page-image', 'ExhibitionPagesController@saveBanner');
// Route::post('/content/exhibition-pages/saveBanner', array('as' => 'exb-page.image.save', 'uses' => 'ExhibitionPagesController@saveBanner'));
// Route::get('delete-page-image', 'ExhibitionPagesController@deletePageImage');
// Route::get('get-banner', 'ExhibitionPagesController@getBanner');
// Route::get('delete-banner', 'ExhibitionPagesController@deleteBanner');
// Route::post('save-banner', 'ExhibitionPagesController@saveBanner');
// Route::post('/save-exb-dl-protection', 'ExhibitionPagesController@saveDLProtection');
// Route::post('/reset-exb-dl-protection', 'ExhibitionPagesController@resetDLProtection');
// Route::post('/delete-exb-dl-terms', 'ExhibitionPagesController@deleteDLTermsFile');
// Route::get('/exb-pages/set-main-exb/{page_id}', 'ExhibitionPagesController@setMainExb');
// Route::get('/exb-pages/unset-main-exb/{page_id}', 'ExhibitionPagesController@unsetMainExb');
Route::get('/content/exhibition-pages', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@index']);
Route::get('/content/pages/create-exb-page', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@create']);
Route::get('/content/exhibition-pages/edit/{id}/{action?}', array('before' => 'auth', 'as' => 'exb-pages.edit', 'uses' => 'ExhibitionPagesController@edit'));
Route::get('/content/exhibition-pages/preview/{id}', array('before' => 'auth', 'as' => 'exb-pages.edit', 'uses' => 'ExhibitionPagesController@preview'));
Route::post('/content/exhibition-pages/update', array('before' => 'auth', 'as' => 'exb-pages.update', 'uses' => 'ExhibitionPagesController@update'));
Route::post('/content/exhibition-pages/store', array('before' => 'auth', 'as' => 'exb-pages.store', 'uses' => 'ExhibitionPagesController@store'));
Route::post('/content/exhibition-pages/save', array('before' => 'auth', 'as' => 'exb-pages.save', 'uses' => 'ExhibitionPagesController@save'));
Route::get('/content/exhibition-pages/delete/{id}', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@destroy']);
Route::post('upload-exb-page-image', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@uploadExhibitionPageImage']);
Route::post('save-page-image', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@saveBanner']);
Route::get('/content/exhibition-pages/delete-pages/', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deletePages']);
Route::post('/content/exhibition-pages/saveBanner', array('before' => 'auth', 'as' => 'exb-page.image.save', 'uses' => 'ExhibitionPagesController@saveBanner'));
Route::get('delete-page-image', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deletePageImage']);
Route::get('get-banner', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@getBanner']);
Route::get('delete-exb-banner', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deleteBanner']);
Route::post('save-banner', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@saveBanner']);
Route::post('/save-exb-dl-protection', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@saveDLProtection']);
Route::post('/reset-exb-dl-protection', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@resetDLProtection']);
Route::post('/delete-exb-dl-terms', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deleteDLTermsFile']);
Route::get('/exb-pages/set-main-exb/{page_id}', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@setMainExb']);
Route::get('/exb-pages/unset-main-exb/{page_id}', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@unsetMainExb']);


/* Page Image Sliders
*/
// Route::get('create-slider', 'PageImageSlidersController@createSlider');
// Route::get('delete-slider', 'PageImageSlidersController@deleteSlider');
// Route::get('/content/page-image-sliders/{cs_id}', 'PageImageSlidersController@index');
// Route::post('/content/page-image-sliders/create', 'PageImageSlidersController@create');
// Route::get('/content/page-image-sliders/edit/{cs_id}/{id}', array('as' => 'page_image_sliders.edit', 'uses' => 'PageImageSlidersController@edit'));
// Route::post('/content/page-image-sliders/update', array('as' => 'page_image_sliders.update', 'uses' => 'PageImageSlidersController@update'));
// Route::post('/content/page-image-sliders/store', array('as' => 'page_image_sliders.store', 'uses' => 'PageImageSlidersController@store'));
// Route::get('/pages/delete-page-banner/{banner_id}/{menu_item_id}/{cs_id}/{id}', 'PagesController@deletePageBanner');
// Route::post('create-new-slider', 'PageImageSlidersController@createNewSlider');
// // Exb
// Route::get('exb-create-slider', 'PageImageSlidersExbController@createSlider');
// Route::get('exb-delete-slider', 'PageImageSlidersExbController@deleteSlider');
// Route::get('/content/exb-page-image-sliders', 'PageImageSlidersExbController@index');
// Route::post('/content/exb-page-image-sliders/create', 'PageImageSlidersExbController@create');
// Route::get('/content/exb-page-image-sliders/edit/{id}', array('as' => 'exb_page_image_sliders.edit', 'uses' => 'PageImageSlidersExbController@edit'));
// Route::post('/content/exb-page-image-sliders/update', array('as' => 'exb_page_image_sliders.update', 'uses' => 'PageImageSlidersExbController@update'));
// Route::post('/content/exb-page-image-sliders/store', array('as' => 'exb_page_image_sliders.store', 'uses' => 'PageImageSlidersExbController@store'));
// Route::get('/pages/delete-exb-page-banner/{banner_id}/{id}', 'ExhibitionPagesController@deletePageBanner');
// Route::post('exb-create-new-slider', 'PageImageSlidersExbController@createNewSlider');
Route::get('create-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersController@createSlider']);
Route::get('delete-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersController@deleteSlider']);
Route::get('/content/page-image-sliders/{cs_id}', ['before' => 'auth', 'uses' => 'PageImageSlidersController@index']);
Route::post('/content/page-image-sliders/create', ['before' => 'auth', 'uses' => 'PageImageSlidersController@create']);
Route::get('/content/page-image-sliders/edit/{cs_id}/{id}', array('before' => 'auth', 'as' => 'page_image_sliders.edit', 'uses' => 'PageImageSlidersController@edit'));
Route::post('/content/page-image-sliders/update', array('before' => 'auth', 'as' => 'page_image_sliders.update', 'uses' => 'PageImageSlidersController@update'));
Route::post('/content/page-image-sliders/store', array('before' => 'auth', 'as' => 'page_image_sliders.store', 'uses' => 'PageImageSlidersController@store'));
Route::get('/pages/delete-page-banner/{banner_id}/{menu_item_id}/{cs_id}/{id}', ['before' => 'auth', 'uses' => 'PagesController@deletePageBanner']);
Route::post('create-new-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersController@createNewSlider']);
// Exb
Route::get('exb-create-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@createSlider']);
Route::get('exb-delete-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@deleteSlider']);
Route::get('/content/exb-page-image-sliders', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@index']);
Route::post('/content/exb-page-image-sliders/create', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@create']);
Route::get('/content/exb-page-image-sliders/edit/{id}', array('before' => 'auth', 'as' => 'exb_page_image_sliders.edit', 'uses' => 'PageImageSlidersExbController@edit'));
Route::post('/content/exb-page-image-sliders/update', array('before' => 'auth', 'as' => 'exb_page_image_sliders.update', 'uses' => 'PageImageSlidersExbController@update'));
Route::post('/content/exb-page-image-sliders/store', array('before' => 'auth', 'as' => 'exb_page_image_sliders.store', 'uses' => 'PageImageSlidersExbController@store'));
Route::get('/pages/delete-exb-page-banner/{banner_id}/{id}', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deletePageBanner']);
Route::post('exb-create-new-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@createNewSlider']);

/* Page Slider Images
*/
// Route::get('/content/page-slider-images/{cs_id}', 'PageSliderImagesController@index');
// Route::get('/content/page-slider-images/create/{cs_id}', 'PageSliderImagesController@create');
// Route::get('/content/page-slider-images/edit/{cs_id}/{id}', array('as' => 'page_slider_images.edit', 'uses' => 'PageSliderImagesController@edit'));
// Route::post('/content/page-slider-images/update', array('as' => 'page_slider_images.update', 'uses' => 'PageSliderImagesController@update'));
// Route::post('/content/page-slider-images/store', array('as' => 'page_slider_images.store', 'uses' => 'PageSliderImagesController@store'));
// Route::get('delete-page-slider-image', 'PageSliderImagesController@deletePageSliderImage');
// Route::post('save-page-slider-image', 'PageSliderImagesController@savePageSliderImage');
// //Edb
// Route::get('/content/exb-page-slider-images/{slider_id}', 'PageSliderImagesExbController@index');
// Route::get('/content/exb-page-slider-images/create/{slider_id}', 'PageSliderImagesExbController@create');
// Route::get('/content/exb-page-slider-images/edit/{page_id}/{slider_image_id}/{id}', array('as' => 'exb_page_slider_images.edit', 'uses' => 'PageSliderImagesExbController@edit'));
// Route::post('/content/exb-page-slider-images/update', array('as' => 'exb_page_slider_images.update', 'uses' => 'PageSliderImagesExbController@update'));
// Route::post('/content/exb-page-slider-images/store', array('as' => 'exb_page_slider_images.store', 'uses' => 'PageSliderImagesExbController@store'));
// Route::get('delete-exb-page-slider-image', 'PageSliderImagesExbController@deletePageSliderImage');
// Route::post('save-exb-page-slider-image', 'PageSliderImagesExbController@savePageSliderImage');
Route::get('/content/page-slider-images/{cs_id}', ['before' => 'auth', 'uses' => 'PageSliderImagesController@index']);
Route::get('/content/page-slider-images/create/{cs_id}', ['before' => 'auth', 'uses' => 'PageSliderImagesController@create']);
Route::get('/content/page-slider-images/edit/{cs_id}/{id}', array('before' => 'auth', 'as' => 'page_slider_images.edit', 'uses' => 'PageSliderImagesController@edit'));
Route::post('/content/page-slider-images/update', array('before' => 'auth', 'as' => 'page_slider_images.update', 'uses' => 'PageSliderImagesController@update'));
Route::post('/content/page-slider-images/store', array('before' => 'auth', 'as' => 'page_slider_images.store', 'uses' => 'PageSliderImagesController@store'));
Route::get('delete-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesController@deletePageSliderImage']);
Route::post('save-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesController@savePageSliderImage']);
//Edb
Route::get('/content/exb-page-slider-images/{slider_id}', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@index']);
Route::get('/content/exb-page-slider-images/create/{slider_id}', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@create']);
Route::get('/content/exb-page-slider-images/edit/{page_id}/{slider_image_id}/{id}', array('before' => 'auth', 'as' => 'exb_page_slider_images.edit', 'uses' => 'PageSliderImagesExbController@edit'));
Route::post('/content/exb-page-slider-images/update', array('before' => 'auth', 'as' => 'exb_page_slider_images.update', 'uses' => 'PageSliderImagesExbController@update'));
Route::post('/content/exb-page-slider-images/store', array('before' => 'auth', 'as' => 'exb_page_slider_images.store', 'uses' => 'PageSliderImagesExbController@store'));
Route::get('delete-exb-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@deletePageSliderImage']);
Route::post('save-exb-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@savePageSliderImage']);


/* H2
*/
// Route::post('/h2/store', 'H2Controller@store');
// Route::post('/h2/save', 'H2Controller@save');
// Route::get('get-h2', 'H2Controller@getH2');
// Route::post('save-h2', 'H2Controller@saveH2');
Route::post('/h2/store', ['before' => 'auth', 'uses' => 'H2Controller@store']);
Route::post('/h2/save', ['before' => 'auth', 'uses' => 'H2Controller@save']);
Route::get('get-h2', ['before' => 'auth', 'uses' => 'H2Controller@getH2']);
Route::post('save-h2', ['before' => 'auth', 'uses' => 'H2Controller@saveH2']);

/* H2text
*/
// Route::post('/h2text/store', 'H2textController@store');
// Route::post('/h2text/save', 'H2textController@save');
// Route::get('get-h2text', 'H2textController@getH2text');
// Route::post('save-h2text', 'H2textController@saveH2text');

// Route::post('/exb-pages/h2text/store', 'H2textExbController@store');
// Route::post('/exb-pages/h2text/save', 'H2textExbController@save');
// Route::get('get-exb-h2text', 'H2textExbController@getH2text');
// Route::post('save-exb-h2text', 'H2textExbController@saveH2text');
Route::post('/h2text/store', ['before' => 'auth', 'uses' => 'H2textController@store']);
Route::post('/h2text/save', ['before' => 'auth', 'uses' => 'H2textController@save']);
Route::get('get-h2text', ['before' => 'auth', 'uses' => 'H2textController@getH2text']);
Route::post('save-h2text', ['before' => 'auth', 'uses' => 'H2textController@saveH2text']);

Route::post('/exb-pages/h2text/store', ['before' => 'auth', 'uses' => 'H2textExbController@store']);
Route::post('/exb-pages/h2text/save', ['before' => 'auth', 'uses' => 'H2textExbController@save']);
Route::get('get-exb-h2text', ['before' => 'auth', 'uses' => 'H2textExbController@getH2text']);
Route::post('save-exb-h2text', ['before' => 'auth', 'uses' => 'H2textExbController@saveH2text']);

/* Youtube
*/
// Route::post('/youtube/store', 'YoutubeController@store');
// Route::post('/youtube/save', 'YoutubeController@save');
// Route::get('get-youtube', 'YoutubeController@getYoutube');
// Route::post('save-youtube', 'YoutubeController@saveYoutube');
Route::post('/youtube/store', ['before' => 'auth', 'uses' => 'YoutubeController@store']);
Route::post('/youtube/save', ['before' => 'auth', 'uses' => 'YoutubeController@save']);
Route::get('get-youtube', ['before' => 'auth', 'uses' => 'YoutubeController@getYoutube']);
Route::post('save-youtube', ['before' => 'auth', 'uses' => 'YoutubeController@saveYoutube']);

/* Audio
*/
// Route::post('/audio/store', 'AudioController@store');
// Route::post('/audio/save', 'AudioController@save');
// Route::get('get-audio', 'AudioController@getAudio');
// Route::post('save-audio', 'AudioController@saveAudio');
Route::post('/audio/store', ['before' => 'auth', 'uses' => 'AudioController@store']);
Route::post('/audio/save', ['before' => 'auth', 'uses' => 'AudioController@save']);
Route::get('get-audio', ['before' => 'auth', 'uses' => 'AudioController@getAudio']);
Route::post('save-audio', ['before' => 'auth', 'uses' => 'AudioController@saveAudio']);

/* Image
*/
// Route::post('/images/save', 'ImagesController@save');
// Route::post('/images/save', array('as' => 'images.save', 'uses' => 'ImagesController@save'));
// Route::get('/images/delete/{id}', 'ImagesController@delete');
// Route::get('get-image', 'ImagesController@getImage');
// Route::post('upload-image', 'ImagesController@uploadImage');
// Route::post('save-image', 'ImagesController@saveImage');
Route::post('/images/save', ['before' => 'auth', 'uses' => 'ImagesController@save']);
Route::post('/images/save', array('before' => 'auth', 'as' => 'images.save', 'uses' => 'ImagesController@save'));
Route::get('/images/delete/{id}', ['before' => 'auth', 'uses' => 'ImagesController@delete']);
Route::get('get-image', ['before' => 'auth', 'uses' => 'ImagesController@getImage']);
Route::post('upload-image', ['before' => 'auth', 'uses' => 'ImagesController@uploadImage']);
Route::post('save-image', ['before' => 'auth', 'uses' => 'ImagesController@saveImage']);

// Image Grid
// Route::post('/image-grid/save', array('as' => 'image_grid.store', 'uses' => 'ImageGridController@store'));
Route::post('/image-grid/save', array('before' => 'auth', 'as' => 'image_grid.store', 'uses' => 'ImageGridController@store'));
Route::post('/update-page-image_grid-image', 'ImageGridController@save');
Route::get('delete-image-grid', ['before' => 'auth', 'uses' => 'ImageGridController@deleteImageGrid']);

Route::get('delete-exb-image-grid', ['before' => 'auth', 'uses' => 'ImageGridExbController@deleteImageGrid']);
// Grid Image
// Route::post('upload-grid-image', 'GridImageController@uploadGridImage');
// Route::get('get-grid-image', 'GridImageController@getImage');
// Route::post('upload-grid-image', 'GridImageController@uploadImage');
// Route::post('save-grid-image', 'GridImageController@save');
// Route::get('delete-grid-image', 'GridImageController@destroy');
// Route::post('/grid_image/store', array('as' => 'grid_image.save', 'uses' => 'GridImageController@save'));
// Route::post('grid-image-preview', 'GridImageController@uploadImage');
Route::post('upload-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@uploadGridImage']);
Route::get('get-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@getImage']);
Route::post('upload-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@uploadImage']);
Route::post('save-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@save']);
Route::get('delete-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@destroy']);
Route::post('/grid_image/store', array('before' => 'auth', 'as' => 'grid_image.save', 'uses' => 'GridImageController@save'));
Route::post('grid-image-preview', ['before' => 'auth', 'uses' => 'GridImageController@uploadImage']);

// Exb
// Route::post('/exb-images/save', 'ImagesExbController@save');
// Route::post('/exb-images/save', array('as' => 'exb-images.save', 'uses' => 'ImagesExbController@save'));
// Route::get('/exb-images/delete/{id}', 'ImagesExbController@delete');
// Route::get('get-exb-image', 'ImagesExbController@getImage');
// Route::post('upload-exb-image', 'ImagesExbController@uploadImage');
// Route::post('save-exb-image', 'ImagesExbController@saveImage');
// Route::post('/exb-image-grid/store', array('as' => 'exb_image_grid.store', 'uses' => 'ImageGridExbController@store'));
// Route::post('update-grid-image', 'GridImageController@update');
Route::post('/exb-images/save', ['before' => 'auth', 'uses' => 'ImagesExbController@save']);
Route::post('/exb-images/save', array('before' => 'auth', 'as' => 'exb-images.save', 'uses' => 'ImagesExbController@save'));
Route::get('/exb-images/delete/{id}', ['before' => 'auth', 'uses' => 'ImagesExbController@delete']);
Route::get('get-exb-image', ['before' => 'auth', 'uses' => 'ImagesExbController@getImage']);
Route::post('upload-exb-image', ['before' => 'auth', 'uses' => 'ImagesExbController@uploadImage']);
Route::post('save-exb-image', ['before' => 'auth', 'uses' => 'ImagesExbController@saveImage']);
Route::post('/exb-image-grid/store', array('before' => 'auth', 'as' => 'exb_image_grid.store', 'uses' => 'ImageGridExbController@store'));
Route::post('update-grid-image', ['before' => 'auth', 'uses' => 'GridImageController@update']);


/* Page Contents
*/
// Route::get('/content/page-contents/{cs_id}', 'PageContentsController@index');
// Route::get('/content/page-contents/create/{cs_id}', 'PageContentsController@create');
// Route::get('/content/page-contents/edit/{cs_id}/{id}', array('as' => 'page_contents.edit', 'uses' => 'PageContentsController@edit'));
// Route::post('/content/page-contents/update', array('as' => 'page_contents.update', 'uses' => 'PageContentsController@update'));
// Route::post('/content/page-contents/store', array('as' => 'page_contents.store', 'uses' => 'PageContentsController@store'));
// Route::post('/content/page-contents/save', array('as' => 'page_contents.save', 'uses' => 'PageContentsController@save'));
// Route::post('store-page-content', 'PageContentsController@store');
// Route::post('update-page-content', 'PageContentsController@updatePageContent');
// Route::get('get-page-content', 'PageContentsController@getPageContent');
// Route::get('delete-page-content', 'PageContentsController@deletePageContent');
// Route::post('store-page-image-slider', 'PageImageSlidersController@storeAjx');
// Route::post('update-page-image-slider', 'PageImageSlidersController@updateAjx');
// Route::get('get-page-slider-image', 'PageSliderImagesController@getPageSliderImage');
// Route::post('update-page-slider-image', 'PageSliderImagesController@updatePageSliderImage');
// Route::post('page-slider-image-preview', 'PageSliderImagesController@upload');
// Route::post('store-page-image-gallery', 'PageSliderImagesController@store');
// Route::get('get-bnr-text', 'PagesController@getBannerText');
// Route::get('delete-bnr-text', 'PagesController@deleteBannerText');
// Route::post('save-bnr-text', 'PagesController@saveBannerText');
// Route::get('get-page-section', 'PageSectionsController@getPageSection');
// Route::get('/page-sections/del-page-section/{menu_item_id}/{cs_id}/{page_id}/{ps_id}/{item_id}/{type}', 'PageSectionsController@deletePageSection');
// Route::get('/page-sections/move-up/{menu_item_id}/{cs_id}/{page_id}/{ps_id}', 'PageSectionsController@moveUp');
// Route::get('/page-sections/move-down/{menu_item_id}/{cs_id}/{page_id}/{ps_id}', 'PageSectionsController@moveDown');
Route::get('/content/page-contents/{cs_id}', ['before' => 'auth', 'uses' => 'PageContentsController@index']);
Route::get('/content/page-contents/create/{cs_id}', ['before' => 'auth', 'uses' => 'PageContentsController@create']);
Route::get('/content/page-contents/edit/{cs_id}/{id}', array('before' => 'auth', 'as' => 'page_contents.edit', 'uses' => 'PageContentsController@edit'));
Route::post('/content/page-contents/update', array('before' => 'auth', 'as' => 'page_contents.update', 'uses' => 'PageContentsController@update'));
Route::post('/content/page-contents/store', array('before' => 'auth', 'as' => 'page_contents.store', 'uses' => 'PageContentsController@store'));
Route::post('/content/page-contents/save', array('before' => 'auth', 'as' => 'page_contents.save', 'uses' => 'PageContentsController@save'));
Route::post('store-page-content', ['before' => 'auth', 'uses' => 'PageContentsController@store']);
Route::post('update-page-content', ['before' => 'auth', 'uses' => 'PageContentsController@updatePageContent']);
Route::get('get-page-content', ['before' => 'auth', 'uses' => 'PageContentsController@getPageContent']);
Route::get('delete-page-content', ['before' => 'auth', 'uses' => 'PageContentsController@deletePageContent']);
Route::post('store-page-image-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersController@storeAjx']);
Route::post('update-page-image-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersController@updateAjx']);
Route::get('get-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesController@getPageSliderImage']);
Route::post('update-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesController@updatePageSliderImage']);
Route::post('page-slider-image-preview', ['before' => 'auth', 'uses' => 'PageSliderImagesController@upload']);
Route::post('store-page-image-gallery', ['before' => 'auth', 'uses' => 'PageSliderImagesController@store']);
Route::get('get-bnr-text', ['before' => 'auth', 'uses' => 'PagesController@getBannerText']);
Route::get('delete-bnr-text', ['before' => 'auth', 'uses' => 'PagesController@deleteBannerText']);
Route::post('save-bnr-text', ['before' => 'auth', 'uses' => 'PagesController@saveBannerText']);
Route::get('get-page-section', ['before' => 'auth', 'uses' => 'PageSectionsController@getPageSection']);
Route::get('/page-sections/del-page-section/{menu_item_id}/{cs_id}/{page_id}/{ps_id}/{item_id}/{type}', 
	['before' => 'auth', 'uses'=>'PageSectionsController@deletePageSection']);
Route::get('/page-sections/move-up/{menu_item_id}/{cs_id}/{page_id}/{ps_id}', ['before' => 'auth', 'uses' => 'PageSectionsController@moveUp']);
Route::get('/page-sections/move-down/{menu_item_id}/{cs_id}/{page_id}/{ps_id}', ['before' => 'auth', 'uses' => 'PageSectionsController@moveDown']);

// For exhibition pages
// Route::get('/content/exb-page-contents', 'PageContentsExbController@index');
// Route::get('/content/exb-page-contents/create', 'PageContentsExbController@create');
// Route::get('/content/exb-page-contents/edit/{id}', array('as' => 'exb_page_contents.edit', 'uses' => 'PageContentsExbController@edit'));
// Route::post('/content/exb-page-contents/update', array('as' => 'exb_page_contents.update', 'uses' => 'PageContentsExbController@update'));
// Route::post('/content/exb-page-contents/store', array('as' => 'exb_page_contents.store', 'uses' => 'PageContentsExbController@store'));
// Route::post('/content/exb-page-contents/save', array('as' => 'exb_page_contents.save', 'uses' => 'PageContentsExbController@save'));
// Route::post('store-exb-page-content', 'PageContentsExbController@store');
// Route::post('update-exb-page-content', 'PageContentsExbController@updatePageContent');
// Route::get('get-exb-page-content', 'PageContentsExbController@getPageContent');
// Route::get('delete-exb-page-content', 'PageContentsExbController@deletePageContent');
// Route::post('store-exb-page-image-slider', 'PageImageSlidersExbController@storeAjx');
// Route::post('update-exb-page-image-slider', 'PageImageSlidersExbController@updateAjx');
// Route::get('get-exb-page-slider-image', 'PageSliderImagesExbController@getPageSliderImage');
// Route::post('update-exb-page-slider-image', 'PageSliderImagesExbController@updatePageSliderImage');
// Route::post('page-exb-slider-image-preview', 'PageSliderImagesExbController@upload');
// Route::post('store-exb-page-image-gallery', 'PageSliderImagesExbController@store');
// Route::get('get-exb-bnr-text', 'ExhibitionPagesController@getBannerText');
// Route::get('delete-exb-bnr-text', 'ExhibitionPagesController@deleteBannerText');
// Route::post('save-exb-bnr-text', 'ExhibitionPagesController@saveBannerText');
Route::get('/content/exb-page-contents', ['before' => 'auth', 'uses' => 'PageContentsExbController@index']);
Route::get('/content/exb-page-contents/create', ['before' => 'auth', 'uses' => 'PageContentsExbController@create']);
Route::get('/content/exb-page-contents/edit/{id}', array('before' => 'auth', 'as' => 'exb_page_contents.edit', 'uses' => 'PageContentsExbController@edit'));
Route::post('/content/exb-page-contents/update', array('before' => 'auth', 'as' => 'exb_page_contents.update', 'uses' => 'PageContentsExbController@update'));
Route::post('/content/exb-page-contents/store', array('before' => 'auth', 'as' => 'exb_page_contents.store', 'uses' => 'PageContentsExbController@store'));
Route::post('/content/exb-page-contents/save', array('before' => 'auth', 'as' => 'exb_page_contents.save', 'uses' => 'PageContentsExbController@save'));
Route::post('store-exb-page-content', ['before' => 'auth', 'uses' => 'PageContentsExbController@store']);
Route::post('update-exb-page-content', ['before' => 'auth', 'uses' => 'PageContentsExbController@updatePageContent']);
Route::get('get-exb-page-content', ['before' => 'auth', 'uses' => 'PageContentsExbController@getPageContent']);
Route::get('delete-exb-page-content', ['before' => 'auth', 'uses' => 'PageContentsExbController@deletePageContent']);
Route::post('store-exb-page-image-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@storeAjx']);
Route::post('update-exb-page-image-slider', ['before' => 'auth', 'uses' => 'PageImageSlidersExbController@updateAjx']);
Route::get('get-exb-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@getPageSliderImage']);
Route::post('update-exb-page-slider-image', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@updatePageSliderImage']);
Route::post('page-exb-slider-image-preview', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@upload']);
Route::post('store-exb-page-image-gallery', ['before' => 'auth', 'uses' => 'PageSliderImagesExbController@store']);
Route::get('get-exb-bnr-text', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@getBannerText']);
Route::get('delete-exb-bnr-text', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@deleteBannerText']);
Route::post('save-exb-bnr-text', ['before' => 'auth', 'uses' => 'ExhibitionPagesController@saveBannerText']);

// Route::get('get-exb-page-section', 'PageSectionsExbController@getPageSection');
// Route::get('/exb-page-sections/del-page-section/{page_id}/{ps_id}/{item_id}/{type}', 'PageSectionsExbController@deletePageSection');
// Route::get('/exb-page-sections/move-up/{page_id}/{ps_id}', 'PageSectionsExbController@moveUp');
// Route::get('/exb-page-sections/move-down/{page_id}/{ps_id}', 'PageSectionsExbController@moveDown');
Route::get('get-exb-page-section', ['before' => 'auth', 'uses' => 'PageSectionsExbController@getPageSection']);
Route::get('/exb-page-sections/del-page-section/{page_id}/{ps_id}/{item_id}/{type}', ['before' => 'auth', 'uses' => 'PageSectionsExbController@deletePageSection']);
Route::get('/exb-page-sections/move-up/{page_id}/{ps_id}', ['before' => 'auth', 'uses' => 'PageSectionsExbController@moveUp']);
Route::get('/exb-page-sections/move-down/{page_id}/{ps_id}', ['before' => 'auth', 'uses' => 'PageSectionsExbController@moveDown']);



/* Events
*/
// Route::get('/events', function() { return View::make('pages.events.index'); });
// Route::get('/content/events', function() { return View::make('pages.k_events.index'); });
// Route::get('/content/events', 'KEventsController@index');
Route::get('/content/events', ['before' => 'auth', 'uses' => 'KEventsController@index']);
Route::get('/content/events/create', function() { 
	return View::make('pages.k_events.create');
});

// Route::get('/content/events/edit/{id}', array('as' => 'events.edit', 'uses' => 'KEventsController@edit'));
// Route::get('/content/events/delete/{id}', 'KEventsController@destroy');
// Route::post('/content/events/delete-kevents', 'KEventsController@deleteKEvents');
// Route::get('del-page-link', 'KEventsController@delPageLink');
Route::get('/content/events/edit/{id}', array('before' => 'auth', 'as' => 'events.edit', 'uses' => 'KEventsController@edit'));
Route::get('/content/events/delete/{id}', ['before' => 'auth', 'uses' => 'KEventsController@destroy']);
Route::post('/content/events/delete-kevents', ['before' => 'auth', 'uses' => 'KEventsController@deleteKEvents']);
Route::get('del-page-link', ['before' => 'auth', 'uses' => 'KEventsController@delPageLink']);

	// function($id) { 
	// return View::make('pages.k_events.edit')->with('k_event', KEvent::find($id)); 
// }));
// Route::post('/kevents/upload', 'KEventsController@upload');
// Route::post('/kevents/duplicate', 'KEventsController@duplicate');
// Route::get('/content/events/delete-kevents', 'KEventsController@deleteKEvents');

// Route::post('/content/events/upload', [ 'as' => 'k_event_image.upload', 'uses' => 'KEventsController@upload' ]);
// Route::get('/content/events/create', 'KEventsController@create');
// Route::post('/content/events/store', 'KEventsController@store');
// Route::post('/content/events/update', 'KEventsController@update');

// Route::get('delete-event-date', 'KEventsController@deleteEventDate');
// Route::post('update-event-dates', 'KEventsController@updateEventDates');
// // Route::get('delete-event-image', 'KEventsController@deleteEventImage');
// Route::get('/kevents/delimage', 'KEventsController@deleteEventImage');

Route::post('/kevents/upload', ['before' => 'auth', 'uses' => 'KEventsController@upload']);
Route::post('/kevents/duplicate', ['before' => 'auth', 'uses' => 'KEventsController@duplicate']);
Route::get('/content/events/delete-kevents', ['before' => 'auth', 'uses' => 'KEventsController@deleteKEvents']);

Route::post('/content/events/upload', [ 'before' => 'auth', 'as' => 'k_event_image.upload', 'uses' => 'KEventsController@upload' ]);
Route::get('/content/events/create', ['before' => 'auth', 'uses' => 'KEventsController@create']);
Route::post('/content/events/store', ['before' => 'auth', 'uses' => 'KEventsController@store']);
Route::post('/content/events/update', ['before' => 'auth', 'uses' => 'KEventsController@update']);

Route::get('delete-event-date', ['before' => 'auth', 'uses' => 'KEventsController@deleteEventDate']);
Route::post('update-event-dates', ['before' => 'auth', 'uses' => 'KEventsController@updateEventDates']);
// Route::get('delete-event-image', 'KEventsController@deleteEventImage');
Route::get('/kevents/delimage', ['before' => 'auth', 'uses' => 'KEventsController@deleteEventImage']);

/* 
   Authentication
*/
Route::any("/login", ["as"   => "user/login", "uses" => "UserController@login"]);
Route::post('/user/authenticate', ['as' => 'user.authenticate', 'uses' => 'UserController@authenticate']);
Route::get('logout', array('uses' => 'UserController@doLogout'));
Route::get('/user/logout', 'UserController@doLogout');


