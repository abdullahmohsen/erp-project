@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">

  <section class="content-header">

    @foreach ($category as $index=>$category)
        <h1>{{ $category->name }}</h1>
    @endforeach

    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard.welcome') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
      <li class="active">@lang('site.subcategories')</li>
    </ol>
  </section>

  <section class="content">

    <div class="box box-primary">

      <div class="box-header with-border">

        <h3 class="box-title" style="margin-bottom: 15px">@lang('site.subcategories') <small>{{ $subcategories->count() }}</small></h3>

      </div><!-- end of box header -->

      <div class="box-body">
        @if($subcategories->count() > 0)
        <table class="table table-bordered">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>@lang('site.subcategories')</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($subcategories as $index=>$category)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $category->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
            <h2>@lang('site.no_subcategoris_found')</h2>
        @endif
      </div><!-- end of box body -->



    </div><!-- end of box -->

  </section><!-- end of content -->

</div><!-- end of content wrapper -->


@endsection
