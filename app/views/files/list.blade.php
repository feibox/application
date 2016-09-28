<div class="col-md-2 sidebar">
        <h3>Navigácia</h3>
        
          <ul class="nav nav-pills nav-stacked">
            <li id="1bc" role="presentation"><a href="#">1. ročník (Bc.)</a></li>
            <li id="2bc" role="presentation"><a href="#">2. ročník (Bc.)</a></li>
            <li id="3bc" role="presentation"><a href="#">3. ročník (Bc.)</a></li>
            <li id="1ing" role="presentation" class="active"><a href="#">1. ročník(Ing.)</a></li>
            <li id="2ing" role="presentation"><a href="#">2. ročník (Ing.)</a></li>
          </ul>
          
          <div class="panel panel-default">
            <div id="sstitle" class="panel-heading">Súborový systém </div>
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a id="pred" href="#">Prednášky<span class="badge">4</span></a></li>
                <li role="presentation" class="active"><a id="cvic" href="#">Cvičenia</a></li>
                <li role="presentation"><a id="zap" href="#">Zápočty</a></li>
              </ul>
            </div>
          </div>

          <div class="panel panel-default">
            <div id="sstitle" class="panel-heading">Panel akcií</div>
            <div class="panel-body">
              <form class="form-horizontal">
              <button type="submit" class="btn btn-default">Vytvoriť adresár</button>
              <p></p>
              <button type="submit" class="btn btn-default">Pridať súbory</button>
            </form>
            </div>
          </div>

          </div>      
        
        
        <div class="col-sm-10 main">
        
        <h3>Dashboard</h3>
        <ol class="breadcrumb">
          @for($i = 0; $i < (count($bread) - 1); $i++)
            <li><a href="{{$bread[$i]->path}}">{{$bread[$i]->name}}</a></li>
          @endfor
          <li class="active">{{$bread[count($bread) - 1]->name}}</li>
        </ol>
         <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Názov</th>
                  <th>Dátum úpravy</th>
                  <th>Veľkosť</th>
                  <th>Typ</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($filelist as $item)
                  <tr>
                    @if ($item->type === "project")
                      <td><a href="{{'../project/' . $item->path}}">{{$item->dispname}}</a></td>
                    @elseif ($item->type === "dir")
                      <td><a href="{{'./files/' . $item->path}}">{{$item->dispname}}</a></td>
                    @else
                      <td><a href="{{'./file/' . $item->path}}">{{$item->dispname}}</a></td>
                    @endif
                    <td>{{$item->datec}}</td>
                    <td>{{$item->size}}</td>
                    <td>{{$item->type}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
         </div>
         
         <script>
            $(document).ready(function(){
                $.fn.change = function(id,text){
                    document.getElementById("1bc").className = "";
                    document.getElementById("2bc").className = "";
                    document.getElementById("3bc").className = "";
                    document.getElementById("1ing").className = "";
                    document.getElementById("2ing").className = "";                                 
                    document.getElementById(id).className = "active";            
                    document.getElementById("cvic").href = './files/' + id + '-cvic';
                    document.getElementById("pred").href = './files/' + id + '-pred';
                    document.getElementById("zap").href = './files/' + id + '-zap';
                    $('#sstitle').html('Súbory pre: ' + text);
                }
                $('#1bc').click(function(){
                    $.fn.change("1bc","1. ročník (Bc.)");
                });
                $('#2bc').click(function(){
                    $.fn.change("2bc","2. ročník (Bc.)");
                });
                $('#3bc').click(function(){
                    $.fn.change("3bc","3. ročník (Bc.)");
                });
                $('#1ing').click(function(){
                    $.fn.change("1ing","1. ročník (Ing.)");
                });
                $('#2ing').click(function(){
                    $.fn.change("2ing","2. ročník (Ing.)");
                });
            });
         </script>