@extends('admin.layout')
@section('content')
   <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                用户详细信息管理
                <small>列表</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">详细信息管理</a></li>
                <li class="active">列表</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">快速查看详细信息</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <form action="{{ url('admin/success/index')}}" method="get">
                                <div class="col-md-4">
                                    <div class="form-group">
                                          
                                                <select class="form-control" name="num">
                                                    <option value="5"
                                                        @if(!empty($request['num']) && $request['num'] == 5)
                                                            selected="selected" 
                                                        @endif
                                                    >5</option>
                                                    <option value="10"
                                                        @if(!empty($request['num']) && $request['num'] == 10)
                                                            selected="selected" 
                                                        @endif
                                                    >10</option>
                                                    <option value="20"
                                                        @if(!empty($request['num']) && $request['num'] == 20)
                                                            selected="selected" 
                                                        @endif
                                                    >20</option>
                                                    <option value="30"
                                                        @if(!empty($request['num']) && $request['num'] == 30)
                                                            selected="selected" 
                                                        @endif
                                                    >30</option>
                                                   
                                                </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-2">
                                    <div class="input-group input-group">
                                        <input class="form-control" type="text" value="{{ $request['keyword'] or '' }}"  name="keyword">
                                        <span class="input-group-btn">
                                        <button class="btn btn-info btn-flat" >搜索</button>
                                        </span>
                                    </div>
                                </div>
                                </form>
                            </div>
                                @if(session('info'))
                                <div  id="showHidden"class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4>    <i class="icon fa fa-check"></i> 提示!</h4>
                                   添加成功
                                </div>
                                @endif
                                <script type="text/javascript">

                                <script type="text/javascript">
                                window.onload = function()
                                {
                                    $("#showHidden").hide(3000);
                                }
                                </script>    
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>真实姓名</th>
                                   
                                    <th>性别</th>
                                    <th>身高</th>
                                    <th>电话</th>
                                    <th>生日</th>
                                    <th>qq号</th>             
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                               @foreach($data as $userdetail)
                                <tr>
                                    <td>{{ $userdetail -> user_id }} </td>
                                    <td>{{ $userdetail -> realname }}</td>
                                    
                                    <td>
                                        @if($userdetail -> sex == 0 )
                                            男
                                        @else
                                            女
                                        @endif
                                    </td>
                                    <td>{{ $userdetail -> height }}</td>
                                    <td>{{ $userdetail -> phone }}</td>
                                    <td>{{ date('Y-m-d H:i:s',$userdetail -> birthday) }}</td>
                                    <td>{{ $userdetail -> qq }}</td>

                                  
                                    <td>
                                    
                                        <a href="{{ url('/admin/userdetail/edit') }}/{{ $userdetail -> id}}">编辑</a>|
                                        <a href="{{ url('/admin/userdetail/delete') }}/{{ $userdetail -> id}}">删除</a>
                                    </td>
                                </tr>
                             @endforeach
                                </tbody>
                            </table>
                           
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

<!-- page script -->
    <script type="text/javascript">
       
        window.onload = function()
        {
            
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });

            //双击修改用户名
            $('td[name=title]').dblclick(db);
        
            function db()
            {
                var td = $(this);

                //获取原来的id
                var id = td.prev().html();
                //获取当前里面的值
                var name = td.html();

                var inp = $('<input type="text"/>');
                inp.val(name);

                //将表单放到td内
                td.html(inp);
                //光标自动对焦
                inp.select();

                //失去焦点事件
                inp.blur(function(){
                    //获取新值
                    var newname = inp.val();

                    // if(name = newname)
                    // {
                    //     alert('你脑子有病');
                    //     td.html(name);
                    // }

                    //发送ajax
                    $.post('/admin/User/ajaxUsername',{id:id,name:newname},function(data){
                        // alert(data);

                        if(data == '1')
                        {
                            alert('用户名已经存在');
                            td.html(name);
                        }else if(data == '0')
                        {
                            td.html(newname);
                        }else
                        {
                            alert('用户名修改失败');
                            td.html(name);
                        }
                    },'json');
                    //添加事件
                    td.dblclick(db);
                });
            //清除事件
             td.unbind('dblclick');
            }
        }
    </script>
@endsection
