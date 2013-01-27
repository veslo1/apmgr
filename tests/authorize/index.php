<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=encoding">
<title>Insert title here</title>
</head>
<body>
<table>
<thead>
	<tr><td>Name</td></tr>
</thead>
<tbody>
<?php
/**
 * @author Jorge Omar Vazquez <jvazquez@debserverp4.com.ar>
 */
$dir = new DirectoryIterator(realpath(dirname(__FILE__)));
foreach($dir as $obj) {
	if( !$obj->isDot() and preg_match('/^\.\w+/',$obj->getFilename())==0 and preg_match('/\.php$/',$obj->getFileName() )==1 and preg_match("/index\.php/",$obj->getFileName())==0 ) { ?>
	<tr><td><a href="<?php echo $obj->getFilename();?>"><?=$obj->getFilename();?></a></td></tr>
	<?php }
}
?>
</tbody>
</table>
</body>
</html>