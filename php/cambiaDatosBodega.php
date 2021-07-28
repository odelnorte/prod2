<?php 
include("../../Conexion/conectaBase.php");
$sd =new conexion();
$sd->conectar();
$valor=$_POST["valorx"];
//echo".$valor.";
$obtieneRackx=mssql_query("select distinct rack from cubicacion2 where bodega = '".$valor."' order by rack asc");
$obtieneRack=mssql_fetch_array($obtieneRackx);
if($valor=='%'){
	echo"
	<span id='cambiaRack'><select id='selectRack'>
	<option value=''></option>
	</select></span>";
	}
if($valor=='Bodega 102'){
echo"
<span id='cambiaRack'><select id='selectRackMaq' onChange='traedatosRack(this.value);'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
<option value='17'>17</option>
<option value='18'>18</option>
<option value='19'>19</option>
<option value='21'>21</option>
<option value='22'>22</option>
<option value='99'>99</option>
</select></span>";}
if($valor=='bodega 2'){
	echo"
	<span id='cambiaRack'><select id='selectRackMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
</select></span>";
	}
if($valor=='bodega 5'){
	echo"
	<span id='cambiaRack'><select id='selectRackMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
</select></span>";
	}
if($valor=='bodega 9'){
	echo"
	<span id='cambiaRack'><select id='selectRackMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
<option value='3'>3</option>
<option value='4'>4</option>
<option value='5'>5</option>
<option value='6'>6</option>
<option value='7'>7</option>
<option value='8'>8</option>
<option value='9'>9</option>
<option value='10'>10</option>
<option value='11'>11</option>
<option value='12'>12</option>
<option value='13'>13</option>
<option value='14'>14</option>
<option value='15'>15</option>
<option value='16'>16</option>
</select></span>";
	}
if($valor=='bodega 1'){
	echo"
	<span id='cambiaRack'><select id='selectRackMaq'>
<option value='1'>1</option>
<option value='2'>2</option>
</select></span>";
	}
$sd->desconectar();
?>