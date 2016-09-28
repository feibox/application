<div class="col-md-2 sidebar">
        <h3>Navigácia</h3>
        
          <ul class="nav nav-pills nav-stacked">
            <li role="presentation"><a href="#">1. ročník (Bc.)</a></li>
            <li role="presentation"><a href="#">2. ročník (Bc.)</a></li>
            <li role="presentation"><a href="#">3. ročník (Bc.)</a></li>
            <li role="presentation" class="active"><a href="#">1. ročník(Ing.)</a></li>
            <li role="presentation"><a href="#">2. ročník (Ing.)</a></li>
          </ul>
          
          <div class="panel panel-default">
            <div class="panel-heading">1. ročník(Ing.)</div>
            <div class="panel-body">
              <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><a href="#">Prednášky<span class="badge">4</span></a></li>
                <li role="presentation" class="active"><a href="#">Cvičenia</a></li>
                <li role="presentation"><a href="#">Zápočty</a></li>
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
          <ul class="nav nav-tabs">
            <li class="active"><a href="{{"#hf" . 0}}" role="tab" data-toggle="tab" aria-expanded="true">{{$projObj[0]->name}}</a></li>
            @for($i = 1; $i < (count($projObj)); $i++)
            <li><a href="{{"#hf" . $i}}" role="tab" data-toggle="tab">{{$projObj[$i]->name}}</a></li>  
            @endfor
          </ul>
          <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active" id="{{"hf" . 0}}">
              <pre>
                <code>
                  {{$projObj[0]->content}}
                </code>
              </pre>
          </div>
          @for($i = 1; $i < (count($projObj)); $i++)
            <div role="tabpanel" class="tab-pane fade" id="{{"hf" . $i}}">
              <pre>
                <code>
                  {{$projObj[$i]->content}}
                </code>
              </pre>
            </div>  
          @endfor
        </div>
        </div>
        <script>
          $(document).ready(function(){
            $(".nav-tabs a").click(function(){
              $(this).tab('show');
            });
          });
        </script>