<?php 



session_start();
header('Content-Type: text/html; charset=UTF-8');

$_codigo_infoideias = $_SESSION['trb_codigo_infoideias'];	
include('../_conexoes/conexao_caminho_e_cliente.php');
		
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link rel="stylesheet" type="text/css" href="css_graficos.css" /> 

<link rel="stylesheet" type="text/css" href="../_lib/buttons/MidasWeb/MidasWeb.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script>
$(function () {
	$('#container').highcharts({
		title: {
			text: 'Percentual de Clientes X Fases - os valores entre parenteses ao lado do nome do corretor representam a quantidade de clientes que foram vinculados ao corretor no periodo selecionado',
			x: -20 //center
		},
		subtitle: {
			text: '',
			x: -20
		},
		xAxis: {
			categories: ['Pré-Contato %', 'Entrevista Cliente %', 'Determinação Perfil %', 'Imovel Selecionado %', 'Visita Realizada %', 'Proposta %',
 				'Negócio Fechado %']


		},
		yAxis: {
			title: {
				text: '',
				layout: 'horizontal',
				align: 'left',
				verticalAlign: 'bottom'
			},
			plotLines: [{
				value: 0,
				width: 3,
				color: '#808080'
			}]
		},
		tooltip: {
			
		},
		legend: {
			layout: 'horizontal',
			align: 'center',
			verticalAlign: 'bottom',
			borderWidth: 0
		},
		series: [<?php 			


$sql = "SELECT  CONCAT(`nome_corretor`, ' (',qtd_total_clientes,')') AS nome_corretor, id_corretor
		FROM   apoio_processo_negociacao
		WHERE id_operador_sistema = ".$_SESSION['trb_id_operador']."
		GROUP BY nome_corretor, id_corretor
		ORDER BY  nome_corretor";
//$sql_midias = mysql_query($sql);
$sql_midias = $conexao->query($sql);



$_SESSION['var_sql_apoio'] = $sql;
$_SESSION['var_sql_midia'] = '';
												

//while($midias = mysql_fetch_array($sql_midias)) {
while ($midias = mysqli_fetch_array($sql_midias))  {
		$sql_performance = "SELECT apoio_processo_negociacao.id_corretor
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil1 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f1'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil2 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f2'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil3 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f3'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil4 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f4'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil5 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f5'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil6 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f6'
		  ,  CASE  WHEN qtd_total_clientes > 0 THEN  ROUND(((qtd_fase_funil7 / qtd_total_clientes) * 100),2)   ELSE 0    END  AS 'f7'
		  
		FROM apoio_processo_negociacao
		WHERE apoio_processo_negociacao.id_operador_sistema = ".$_SESSION['trb_id_operador']." 
				AND apoio_processo_negociacao.id_corretor = ".$midias['id_corretor']." 
		GROUP BY apoio_processo_negociacao.id_corretor ";

		//$sql_valores = mysql_query($sql_performance);	
		$sql_valores = $conexao->query($sql_performance);						

		$_SESSION['var_sql_midia'] .= $sql_performance;


		//$valor = mysql_fetch_array($sql_valores);
	    $valor = mysqli_fetch_array($sql_valores)  ;
												echo "{ name: '".$midias['nome_corretor']."', data: [";										
												
												echo $valor['f1'].",";
												echo $valor['f2'].",";
												echo $valor['f3'].",";
												echo $valor['f4'].",";
												echo $valor['f5'].",";
												echo $valor['f6'].",";
												echo $valor['f7'].",";
												echo "]
												},";
											
									}						

						?>]
	});
	

});
</script>
</head>

<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>
<table style="border-collapse: collapse; border-width: 0px; width: 100%"><tbody><tr><td class="scFormToolbar" style="padding: 0px; spacing: 0px">
    <table style="border-collapse: collapse; border-width: 0px; width: 100%">
    <tbody><tr> 
     <td nowrap="" align="left" valign="middle" width="33%" class="scFormToolbarPadding"> 
     </td> 
     <td nowrap="" align="center" valign="middle" width="33%" class="scFormToolbarPadding"> 
     </td> 
     <td nowrap="" align="right" valign="middle" width="33%" class="scFormToolbarPadding"> 
       <a href="../control_grafico_processo_negociacao/" >

       	<span id="sc_voltar_filtro_top"  class="scButton_default" style="vertical-align: middle; display: inline-block;" onmouseover="if(this.disabled){ return false; }else{ main_style = this.className; this.style.cursor='pointer'; this.className = 'scButton_onmouseover'; }" onmouseout="if(this.disabled){ return false;  }else{ this.style.cursor=''; this.className = main_style; }" onmousedown="if(this.disabled){ return false; }else{ this.style.cursor='pointer'; this.className = 'scButton_onmousedown'; }" onmouseup="if(this.disabled){ return false;   }else{ this.style.cursor='pointer'; this.className = 'scButton_onmouseover'; }">Retornar</span>
       </a>
 
   </td></tr> 
   </tbody></table> 
   </td></tr></tbody></table>


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #749bcf;">
  <tr>
    <th height="25" align="left" valign="middle" nowrap="nowrap" class="titulo_table">Análise Gráfica das Fases do Funil <?php echo $_SESSION['var_titulo_performance']; ?></th>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td><div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
