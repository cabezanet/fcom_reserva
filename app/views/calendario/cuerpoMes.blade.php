
<!-- Primera semana -->
<tr class="fila">
@for($d=1;$d<=7;$d++)
  @if($d < $calendario->diaSemanaPrimerDia)
    <td class="celda">No es de este mes</td>
  @else
    <td class="celda">
        @foreach ($calendario->dia[0][$d]->eventos as $evento)
            {{$evento->titulo}}
        @endforeach
    </td>
  @endif
@endfor
</tr>

<!-- semanas centrales -->
@for ($s = 1; $s < $calendario->numeroSemanas; $s++) 
  <tr class="fila">

    @for($d=1;$d<=7;$d++)
    	
      <td class="celda">

        @foreach ($calendario->dia[$s][$d]->eventos as $evento)
            {{$evento->titulo}}
        @endforeach

      </td>
      
    @endfor
  </tr>
@endfor 

<!-- ultima semana -->
<tr class="fila">
@for($d=1;$d<=7;$d++)

  @if($d <= $calendario->diaSemanaUltimoDia)
      <td class="celda">

        @foreach ($calendario->dia[$s][$d]->eventos as $evento)
            {{$evento->titulo}}
        @endforeach

      </td>
  @else
    <td class="celda">No es de este mes</td>
  @endif

@endfor
</tr>
