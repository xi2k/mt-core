<?php
class IndexApplication extends Application {
	public function main ($args, $params)
	{
		$theme = Template::Get("default", $this);
		$theme->title = "Index page";
		$theme->Draw("index/index", null);
	}
};
?>