<?php

namespace Botble\Sitemap\Http\Controllers;

use Botble\Setting\Http\Controllers\SettingController;
use Botble\Sitemap\Forms\Settings\SitemapSettingForm;
use Botble\Sitemap\Http\Requests\SitemapSettingRequest;

class SitemapSettingController extends SettingController
{
    public function edit()
    {
        $this->pageTitle(trans('packages/sitemap::sitemap.settings.title'));

        return SitemapSettingForm::create()->renderForm();
    }

    public function update(SitemapSettingRequest $request)
    {
        return $this
            ->performUpdate($request->validated())
            ->withUpdatedSuccessMessage();
    }
}
