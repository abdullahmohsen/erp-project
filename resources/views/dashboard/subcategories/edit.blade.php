@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.categories')</h1>

            <ol class="breadcrumb">
                <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.subcategories.index') }}"> @lang('site.categories')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.subcategories.update', $category->id) }}" method="post">

                        @csrf
                        @method('put')

                        <input type="hidden" class="form-control" value="{{ $category->id }}">

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label>@lang('site.' . $locale . '.name')</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $category->translate($locale)->name }}">
                            </div>
                        @endforeach

                        <div class="form-group">
                            <label>@lang('site.slug')</label>
                            <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.choosecategory')</label>
                            <select name="parent_id" class="form-control select2" style="width: 100%;">
                                <optgroup label="Please choose the category">
                                    @if($categories && $categories->count() > 0)
                                        @foreach($categories as $mainCategory)
                                            <option
                                                value="{{ $mainCategory->id }}" @if($mainCategory->id == $category->parent_id) selected @endif>{{ $mainCategory->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>@lang('site.status')</label>
                            <input type="checkbox" value="1" class="minimal" name="is_active"
                            @if($category -> is_active == 1) checked @endif>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
