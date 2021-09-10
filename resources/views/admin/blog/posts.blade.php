@extends('layouts.admin.index')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Blog Posts Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Blog Posts List
            @can('create categories')
              <a href ='{{ route('admin.blog_posts.create') }}' class="btn btn-sm btn-success float-right">Add New Post</a>
            @endcan
          </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Post ID</th>
                  <th class="wd-15p">Post Title</th>
                  <th class="wd-15p">Post Category</th>
                  <th class="wd-15p">Post Image</th>
                  @canany(['edit blog', 'delete blog'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($posts as $key => $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->post_title }}</td>
                        <td>{{ $post->category->blog_category_name }}</td>
                        <td>
                            <img src="{{ $post->post_image }}" alt="" width="100" height="40">
                        </td>
                        @canany(['edit blog', 'delete blog'])
                          <td>
                          @can('edit blog')
                            <a href ='{{ route('admin.blog_posts.edit', $post->id) }}' class="btn btn-sm btn-info">Edit</a>
                          @endcan
                          @can('delete blog')
                            <form method="POST" action='{{ route('admin.blog_posts.destroy', $post->id) }}' class="btn btn-sm btn-danger delete">
                              @csrf @method('DELETE') Delete
                            </form>
                          @endcan
                          </td>
                        @endcanany
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->      
@endsection