<?php
$minuend=0;
while(true)
{
  $curr_date=strtotime(date('Y-m-d'));
  $birthday_date_build=date('Y')-$minuend.'-09-06';

  //echo $birthday_date_build . "\n";

  $birthday_date=strtotime($birthday_date_build);
  $diff_in_seconds=$curr_date - $birthday_date;
  $diff_in_days=round($diff_in_seconds/(60*60*24));

  if($diff_in_days>=0) break;
  else $minuend=1;
}

echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="Shift_JIS">
	<title>Birthday days ago</title>
</head>
<body>
<canvas id="canvas-wrapping"></canvas>
<input type="hidden" id="is_birthday" value="0">
';

if($diff_in_days!=0)
{
  echo '<p style="font-size:35px;"> Birthday was '.$diff_in_days .' days ago </p>';
}
if($diff_in_days==0)
{
  echo '<p style="font-size:35px; color:red;"> Birthday today!</p>';
  echo '<p style="font-size:25px; color:black;"> Prepare your gifts ;-)</p>';
}
else if($diff_in_days%10==0)
{
  echo '<p style="font-size:25px; color:red;"> Aninersary!</p>';
}

echo '<div class="footer">
      <a href="https://exch.com.ua/Bio.php" style="text-decoration:none; color:#007aff;">Arsenii’s Technologies</a>
    </div>';
    
echo '
</body>
<style>
  body
  {
    font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  #canvas-wrapping 
  {
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:999;
    pointer-events:none;
  }

  .footer 
  {
    font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    position:fixed;
    bottom:20px;
    right:20px;
    font-size:1rem;
    color:#6e6e73;
    background:rgba(220, 220, 220, 0.7);
    padding:5px 10px;
    border-radius:10px;
    box-shadow:0 2px 4px rgba(0, 0, 0, 0.1);
    color:#007aff;
  }
</style>';

echo '
<script>
document.addEventListener("DOMContentLoaded", () => 
{
  let send_build="is_birthday";
  console.log(send_build);

  var url="/Bio.php";

  fetch(url, 
  {
    method:"POST",
    headers:
    {
      "Content-Type":"application/x-www-form-urlencoded" //application/x-www-form-urlencoded
    },
    body:new URLSearchParams(send_build)
  })
  .then(response => response.text())
  .then(text => 
  {
    console.log("sent");
    console.log(text);
    if(text=="true")
    {
      console.log("Birthday!");
      document.getElementById("is_birthday").value=1;
      render_confetti();

      function set_width()
      {
        if(document.getElementById("is_birthday").value=="1")
        {
          render_confetti();
          console.log("rerender");
        }
      }
      window.addEventListener("resize", set_width);
    }
    else
    {
      console.log("Not birthday");
    }
  })
  .catch(error => 
  {
    console.error("Error:", error);
  })
});


function setup_canvas(id) 
{
  const canvas=document.getElementById(id)
  canvas.width=window.innerWidth
  canvas.height=window.innerHeight
  const ctx=canvas.getContext("2d")
  return { canvas, ctx }
}

const colors=["#ff0", "#f0f", "#0ff", "#0f0", "#f00", "#00f"]
const { canvas, ctx }=setup_canvas("canvas-wrapping"); 
  function render_confetti() 
  {
    const timeDelta=0.05;
    const xAmplitude=0.5;
    const yAmplitude=1;
    const xVelocity=2;
    const yVelocity=3;

    let time=0;
    const confetti=[]

    for (let i=0; i<100; i++) 
    {
      const radius=Math.floor(Math.random()*50)-10
      const tilt=Math.floor(Math.random()*10)-10
      const xSpeed=Math.random()*xVelocity-xVelocity/2
      const ySpeed=Math.random()*yVelocity
      const x=Math.random()*canvas.width;
      const y=Math.random()*canvas.height-canvas.height;

      confetti.push
      ({
        x,
        y,
        xSpeed,
        ySpeed,
        radius,
        tilt,
        color: colors[Math.floor(Math.random()*colors.length)],
        phaseOffset: i, // Randomness from position in list
      })
    }

    function update() 
    {
      // Run for at most 10 seconds
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      confetti.forEach((piece, i) => 
      {
        piece.y+=(Math.cos(piece.phaseOffset+time)+1)*yAmplitude+piece.ySpeed;
        piece.x+=Math.sin(piece.phaseOffset+time)*xAmplitude+piece.xSpeed;
        // Wrap around the canvas
        if (piece.x<0) piece.x=canvas.width;
        if (piece.x>canvas.width) piece.x=0;
        if (piece.y>canvas.height) piece.y=0;
        ctx.beginPath();
        ctx.lineWidth=piece.radius/2;
        ctx.strokeStyle=piece.color;
        ctx.moveTo(piece.x+piece.tilt+piece.radius/4, piece.y);
        ctx.lineTo(piece.x+piece.tilt, piece.y+piece.tilt+piece.radius/4);
        ctx.stroke();
      })
      time+=timeDelta;
      requestAnimationFrame(update);
    }
    update();
  }

  if(document.getElementById("is_birthday").value=="1") render_confetti();
</script>
';

?>
