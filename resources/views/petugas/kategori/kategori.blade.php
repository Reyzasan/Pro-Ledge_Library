 @extends('desain.sidebarpetugas')
 <!-- START DATA -->
 @section('konten')
     @if (Session::has('success'))
         <div class="pt-3">
             <div class="alert alert-success">
                 {{ Session::get('success') }}
             </div>
         </div>
     @endif

     <div class="my-3 p-3 bg-body rounded shadow-sm">
         <!-- FORM PENCARIAN -->
         <div class="pb-3">
             <form class="d-flex" action="{{url('kategoris')}}" method="get">
                 <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}"
                     placeholder="Masukkan kata kunci" aria-label="Search">
                 <button class="btn btn-secondary" type="submit">Cari</button>
             </form>
         </div>

        <!-- TOMBOL TAMBAH DATA -->
        <div class="pb-3">
             <a href="{{route('print-kategori-petugas')}}?export=pdf" class="btn btn-primary">Print</a>
             <a href='{{ url('kategoris/create') }}' class="btn btn-primary">Tambah Data</a>
         </div>

         <table class="table table-striped">
             <thead>
                 <tr>
                     <th class="col-md-1">No</th>
                     <th class="col-md-2">ID</th>
                     <th class="col-md-4">Kategori</th>
                     <th class="col-md-2">Deskripsi</th>
                     <th class="col-md-2">Aksi</th>
                 </tr>
             </thead>
             <tbody>
                 <?php $i = $data->firstItem(); ?>
                 @foreach ($data as $item)
                     <tr>
                         <td>{{ $i }}</td>
                         <td>{{ $item->id }}</td>
                         <td>{{ $item->kategori}}</td>
                         <td>{{ $item->deskripsi }}</td>
                         <td>
                             <a href='{{ url('kategoris/' . $item->id . '/edit') }}' class="btn btn-warning btn-sm">Edit</a>
                             <form onsubmit="return confirm('Yakin Data Akan Dihapus')" class="d-inline"
                                 action="{{ url('kategoris/' . $item->id) }}" method="post">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit" name="submit" class="btn btn-danger btn-sm">Del</button>
                             </form>
                         </td>
                     </tr>
                     <?php $i++; ?>
                 @endforeach
             </tbody>
         </table>

     </div>
     <!-- AKHIR DATA -->
 @endsection
