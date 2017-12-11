<!doctype html>
<html lang="en">
    <head>
        <title>File Manager</title>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="panel panel-default col-md-6">
                <!-- Default panel contents -->
                <div class="panel-heading">File Manager</div>
                <div class="panel-body">
                    @if($dir['back'])
                    <ul class="nav nav-pills">
                        <li class="active"><a href="/">Главную</a></li>
                        <li><a href="{{ url($dir['back']) }}">Назад</a></li>
                    </ul>
                    @endif
                </div>
                <div class="panel-body">
                    <p>{{$dir['top']}}</p>
                </div>
                <!-- Table -->
                <div class="row col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Папки</th>
                                <th>Доступ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($dir['dirname']))
                            @foreach($dir['dirname'] as $dirname => $access)
                            <tr>
                                @if($access == 'Allow')
                                <td><a href="{{url($dir['root'].$dirname)}}">{{$dirname}}</a></td>
                                <td>Разрешено</td>
                                @else
                                <td>{{$dirname}}</td>
                                <td>Запрещено</td>
                                @endif
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">Папок нет</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- Table -->
                <div class="row col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Файл</th>
                                <th>Размер</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(is_array($dir['file']))
                            @foreach($dir['file'] as $file)
                            <tr>
                                <td>{{$file['name']}}</td>
                                <td>{{$file['size']}}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">Файлов нет</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>