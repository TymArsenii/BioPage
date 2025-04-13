<?
if(isset($_POST['is_birthday']))
{
  if (date('d-m')==='06-09')
  {
    echo 'true';
  }
  else
  {
    echo 'false';
  }
  exit;
}
?>

<!DOCTYPE html>
<html xmlns="//www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>ArseniiUA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="keywords" content="">
  <meta name="resource-type" content="Document">
  <meta name="robots" content="ALL">
  <meta http-equiv="Pragma" content="no-cache">
  <meta name="theme-color" content="#a2deae">
  <meta name="author" content="Arsenii Tymoshenko">

  <!-- <link rel="Website Icon" type="svg"

	href="AquaPilotLogo-with-grass.svg"> -->
</head>

<body>
<canvas id="canvas-wrapping"></canvas>
  <div class="back" style="background-color:#a2deae;">
    <a href="/">&nbsp; ←Menu</a>
  </div>
  <div style="margin-bottom:30px;"></div>
  

  <div style="padding-bottom:50px;"></div>
  <div style="width:auto;">
    <div class="top_square">
      <?php
      function strtotime_to_years($timestamp) 
      {
        $current_time=time();
        $difference_in_seconds=$current_time-$timestamp;
        $seconds_in_a_year=60*60*24*365.25;
        $years=$difference_in_seconds/$seconds_in_a_year;

        return floor($years);
      }
      $date_of_birth='2008-09-06 00:00'; // 13:05
      $result=strtotime_to_years(strtotime($date_of_birth));
      ?>
      <b style="background-color:#b9d3f0; display:block; font-size:35px;">Arsenii <?php echo $result; ?> y.o</b>
      <b class="top_text">Engineer, creator, professional (almost :-) ) software developer</b>
      <b>Telegram:</b>
      <a href="https://t.me/ArseniiUA">@ArseniiUA</a>
      <br>
      <b>Instagram:</b>
      <a href="https://www.instagram.com/tym_arsenii/">Tym_Arsenii</a>
      <br>
      <b>Email:</b>
      <b>Tym.Arsenii@icloud.com</b>
      <br>
      <b style="color:#b9d3f0">Email:</b>
      <b>Tym.Arsenii@gmail.com</b>
    </div>

    <div class="bottom_square">
      <b style="font-size:30px; color:#808080"; margin-bottom:5px;>Projects:</b>
      <a href="https://github.com/tymarsenii">GitHub</a>
      <div style="margin:10px;"></div>

      <b class="bottom_text"><span style="color:#000;">AquaPilot — </span>Sprinklers controller</b> 
      <b class="bottom_text"><span style="color:#000;">Game Console — </span>Tiny Game Console with several classic games</b>
      <b class="bottom_text"><span style="color:#000;">BlindSystem — </span>Blind gear drive with AppleHome capability</b>
      <b class="bottom_text"><span style="color:#000;">StripOS — </span>Powerful OS for addressable LED strips [updated]</b>
      <b class="bottom_text"><span style="color:#000;">SolenoidEngine — </span>Single piston solenoid engine</b>
      <b class="bottom_text"><span style="color:#000;">DigiSandClock — </span>Awesome digtal sand clock [updated]</b>
      <b class="bottom_text"><span style="color:#000;">ChristmasDecoration — </span>Round PCB with 8x8 matrix and a bunch of effects (New!)</b>
      <b style="display:flex; justify-content:end; color:#969595;">And others...</b>
    </div>
  </div>

  <input type="hidden" id="is_birthday" value='0'>
</body>

<script>
document.addEventListener('DOMContentLoaded', () => 
{
  let send_build='is_birthday';
  console.log(send_build);

  var url='/Bio.php';

  fetch(url, 
  {
    method:'POST',
    headers:
    {
      'Content-Type':'application/x-www-form-urlencoded' //application/x-www-form-urlencoded
    },
    body:new URLSearchParams(send_build)
  })
  .then(response => response.text())
  .then(text => 
  {
    console.log('sent');
    console.log(text);
    if(text=='true')
    {
      console.log('Birthday!');
      document.getElementById('is_birthday').value=1;
      render_confetti();

      function set_width()
      {
        if(document.getElementById('is_birthday').value=='1')
        {
          render_confetti();
          console.log('rerender');
        }
      }
      window.addEventListener('resize', set_width);
    }
    else
    {
      console.log('Not birthday');
    }
  })
  .catch(error => 
  {
    console.error('Error:', error);
  })
});


function setup_canvas(id) 
{
  const canvas=document.getElementById(id)
  canvas.width=window.innerWidth
  canvas.height=window.innerHeight
  const ctx=canvas.getContext('2d')
  return { canvas, ctx }
}

const colors=['#ff0', '#f0f', '#0ff', '#0f0', '#f00', '#00f']
const { canvas, ctx }=setup_canvas('canvas-wrapping'); 
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
        color:colors[Math.floor(Math.random()*colors.length)],
        phaseOffset:i, // Randomness from position in list
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

  if(document.getElementById('is_birthday').value=='1') render_confetti();
</script>

<style>
  @font-face
  {
    font-family:'SFProRegular';
    src:url('SF-Pro-Text-Regular.woff') format('woff');
  }

  body
  {
    margin-top:20px;
    display:flex;
    justify-content:center;
    font-family:Arial, Helvetica, sans-serif;
    background-color:#F8F4EE;
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


  .back
	{
		background-color:#a2deae;
		width:100%;
		position:fixed;
		z-index:4;
		margin-bottom:10px;
    top:0;
    display:inline-block;
	}

  .top_text
  {
    display:block;
    background-color:#b9d3f0;
  }

  .bottom_text
  {
    display:block;
    background-color:#f3eebd;
    color:#00589c;
  }

  .top_square
  {
    padding-left:10px;
    padding-top:10px;
    padding-bottom:10px;
    padding-right:100px;
    background-color:#b9d3f0; 
    border-radius:8px 8px 0 0;
  }

  .bottom_square
  {
    padding-left:10px;
    padding-top:10px;
    padding-bottom:10px;
    padding-right:80px;
    background-color:#f3eebd;
    display:block;
    line-height:150%;
    border-radius:0 0 8px 8px;
  }
</style>
</html>
