<?php
if(!defined('IN_KKFRAME')) exit('Access Denied');
class ishifu_mail extends mailer{
	var $id = 'ishifu_mail';
	var $name = 'Ishifu Mailer';
	var $description = 'Ishifu提供的邮件代理发送邮件 (发送者显示 Ishifu-Open-Mail-System &lt;open_mail_api@ishifu.top&gt;)';
	var $config = array(
		array('<p>推荐地址:</p><p>http://yule.ishifu.top/mail/</p>API地址', 'agentapi', '', ''),
		);
	function isAvailable() {
		return true;
	}
	function post($url, $content) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	function send($mail) {
		$data = array(
			'to' => $mail -> address,
			'title' => $mail -> subject,
			'content' => $mail -> message,
			);
		$agentapi = $this -> _get_setting('agentapi');
		$sendresult = json_decode($this -> post($agentapi, $data), true);
		if ($sendresult['err_no']==0) return true;
		return false;
	}
}
?>
