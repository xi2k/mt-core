<?php
class ErrorApplication extends Application {
	public function main ($args, $params)
	{
		$settings = System::GetSettings();
		
		$theme = Themes::Get("default", $this);
		$template = $theme->GetTemplate("default");
		
		$errorNumber = "unknown";
		$errorText = "Just error";
		
		if (!empty($params["errorNumber"]))
			$errorNumber = $params["errorNumber"];
			
		if (!empty($params["errorText"]))
			$errorText = $params["errorText"];
		
		$theme->title = "Error ".$errorNumber;
		$theme->errorNumber = $errorNumber;
		$theme->errorText = $errorText;
		$theme->Draw("default", null);
	}
};
?>