<?php 


function myhash($str, $len=null)
{
    $binhash = md5($str, true);
    $numhash = unpack('N2', $binhash);
    $hash = $numhash[1] . $numhash[2];
    if($len && is_int($len)) {
        $hash = substr($hash, 0, $len);
    }
    return $hash;
}

function generateCode($id, $codeLength){
  // $id = 521217;
  // $codeLength = 5;

  $value = abs(myhash($id, $codeLength));
  $code = str_pad($value, $codeLength, '0', STR_PAD_LEFT);

  return $code;
}

 ?>