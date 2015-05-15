<?php
class ApiReplicatePage extends ApiBase {

	public function execute() {

		$params = $this->extractRequestParams();

		$status = ReplicatePage::executeReplicate( $params['source'], $params['target'] );

		$this->getResult()->addValue( null, $this->getModuleName(), array ( 'status' => $status ) );

		return true;

	}
	public function getAllowedParams() {
		return array(
			'source' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			),
			'target' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true
			)
		);
	}

	public function getDescription() {
		return array(
			'API for triggering page replication'
		);
	}
	public function getParamDescription() {
		return array(
			'source' => 'Source Page',
			'target' => 'Target Page'
		);
	}

	public function getVersion() {
		return __CLASS__ . ': 1.1';
	}
}