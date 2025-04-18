@extends('index_Admin')
@section('Admin_Content')

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <select class="input-sm form-control w-sm inline v-middle">
          <option value="0">Bulk action</option>
          <option value="1">Delete selected</option>
          <option value="2">Bulk edit</option>
          <option value="3">Export</option>
        </select>
        <button class="btn btn-sm btn-default">Apply</button>
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
          <input type="text" class="input-sm form-control" placeholder="Search">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            </th>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Tình trạng đơn hàng</th>
            <th>Trạng thái</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php
          $i=0;
          @endphp
        @foreach($all_order as $key => $order)

        @php
        $i++;
        @endphp
          <tr>
            <td>{{$i}}</td>
            <td>{{$order->id}}</td>

            <td>
                <?php
                if ($order -> order_status == 0) {
                    echo 'Đang xử lý';
                }else{
                    echo 'Đang giao';
                }
                ?>
            </td>
            <td>

                @if ($order -> order_status == 0)
                <a href="{{URL::to('/handle/'.$order->id)}}" class="active" ui-toggle-class="">Duyệt</a>

@endif
                </td>
            <td>

              <a href="{{URL::to('/view-order/'.$order->id)}}" class="active" ui-toggle-class="">
                <i class="fa fa-eye text-success text-active"></i>
              </a>
              <a href="{{URL::to('/Receipt/'.$order->id)}}" class="active" ui-toggle-class="">
                <i class="fa-solid fa-print"></i>
              </a>
              <a onclick="return confirm('Bạn có muốn xóa đơn hàng này không?')" href="{{URL::to('/delete-order/'.$order->id)}}" class="active" ui-toggle-class="">
                <i class="fa fa-times text-danger text"></i>
              </a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">

        <div class="col-sm-5 text-center">
          <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
        </div>
        <div class="col-sm-7 text-right text-center-xs">
          <ul class="pagination pagination-sm m-t-none m-b-none">
            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
            <li><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>

@endsection
