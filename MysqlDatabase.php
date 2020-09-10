<?php
	/**
	* undocumented class
	*
	* @package default
	* @author 
	**/
	class MysqlDatabase
	{


		/**
		 * undocumented class variable
		 *
		 * @var string
		 **/
		private $__mysqlMapsKeys;

		/**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlWhere;

        /**
		 * undocumented class variable
		 *
		 * @var array
		 **/
        private $__mysqlParameters = [];

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlAll = 'all';

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlValidatedParams;

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlInsert;

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlRows;

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlColumns;

        /**
		 * undocumented class variable
		 *
		 * @var string
		 **/
        private $__mysqlTableFields;

        /**
         * undocumented class variable
         *
         * @var string
         **/
        protected $__mysqlColumnsDefinitions = [/*
                                          'Null' => [
                                                      'YES' => 'Null',
                                                      'NO' => ''
                                                  ],*/
                                          'Extra' => [
                                                      'on update CURRENT_TIMESTAMP' => 'CURRENT_TIMESTAMP',
                                                      'auto_increment' => 'NULL'
                                                  ],
                                          /*'Default' => [
                                                      'CURRENT_TIMESTAMP'
                                                  ]*/
                                      ];
		/**
		 * undocumented class variable
		 *
		 * @var void
		 **/
		private $query;

        /**
         * undocumented function
         *
         * @return PDO
         * @author
         */
        protected function getConnection()
        {

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                // PDO::ATTR_AUTOCOMMIT => true,
            ];

            try{

                $server = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,
                    DB_USER,
                    DB_PASS,
                    $options
                );

                $server->exec("set names utf8");
                return $server;

            }catch( PDOException $exception ){

                exit("<h1 style='color:red;text-align:center;text-transform: full-width;font-size: 45px;'>Oooops...</h1><p style='background: #e196a1;padding: 15px;margin-bottom: 20px;border: 1px solid transparent;border-radius: 0px;font-style: oblique;'>Server connection aborted: <strong style='color: red;'>".$exception->getMessage().'.</strong><br> If this persist Please contact IT Help Desk.</p>');

            }
        }

        /**
         * undocumented function
         *
         * @param null $query
         * @return bool|PDOStatement
         * @author
         */
		public function __mysqlStart($query = null){
			try{
				return $this->getConnection()->prepare($this->query);
			}catch(PDOException $exception){
				die("SQL Error [".$query."] in [".__FUNCTION__.'] function => '.$exception->getMessage());
			}
		}

        /**
         * undocumented function
         *
         * @return MysqlDatabase
         * @author
         */
      public function __mysqlWhere()
      {
        if (! empty($this->__mysqlParameters)) {
          $index = 0;
          $parameters = ' WHERE ';

          foreach ($this->__mysqlParameters as $key => $value) {
              if($this->__mysqlMapsKeys)
                  $parameters .= $key.'=:'.$value;
              else
                  $parameters .= $value.'=:'.$value;

              $index++;

              if ($index < sizeof($this->__mysqlParameters)) $parameters .= ' AND ';
          }

          $this->__mysqlWhere = $parameters;
        }

        return $this;
      }

      /**
       * undocumented function
       *
       * @return void
       * @author 
       **/
      public function __mysqlWhereNot(array $parameters = [])
      {
        if (! empty($parameters)) {
          $index = 0;
          $parameters = ' WHERE ';

          foreach ($parameters as $key => $value) {
              if($this->__mysqlMapsKeys)
                  $parameters .= $key.'!=:'.$value;
              else
                  $parameters .= $value.'!=:'.$value;

              $index++;

              if ($index < sizeof($parameters)) $parameters .= ' AND ';
          }

          $this->__mysqlWhere = $parameters;
        }

        return $this;
      }

      /**
       * undocumented function
       *
       * @return void
       * @author 
       **/
      public function __mysqlCount(array $parameters = [])
      {
        
      }

        /**
         * undocumented function
         *
         * @param array $parameters
         * @return MysqlDatabase
         * @author
         */
      public function __mysqlCountWhere(array $parameters = [])
      {
        	$this->query = "SELECT * FROM $this->table $this->__mysqlWhere($parameters)";
          	$result = $this->__mysqlStart();
          	$result->execute($this->__mysqlValidate(
						$this->unsetParams(
							$parameters
						)
					)->__mysqlValidatedParams);
			$this->__mysqlCount = (int)$result->rowCount();
			return $this;
      }

        /**
         * undocumented function
         *
         * @param array $parameters
         * @return MysqlDatabase
         * @author
         */
      public function __mysqlCountWhereNot(array $parameters = [])
      {
        	$this->query = "SELECT * FROM $this->table ".$this->__mysqlWhereNot($parameters)." ";
        	$result = $this->__mysqlStart();
          	$result->execute($this->__mysqlValidate(
						$this->unsetParams(
							$parameters
						)
					)->__mysqlValidatedParams);
			$this->__mysqlCount = (int)$result->rowCount();
			return $this;
      }

        /**
         * undocumented function
         *
         * @param array $params
         * @return MysqlDatabase
         * @author
         */
      public function __mysqlParameters($params = [])
      {
        $this->__mysqlParameters = $params;
        return $this;
      }

        /**
         * undocumented function
         *
         * @param bool $maps
         * @return MysqlDatabase
         * @author
         */
		public function __mysqlMapsKeys($maps = false)
		{
			$this->__mysqlMapsKeys = $maps;
			return $this;
		}

		/**
		 * undocumented function
		 *
		 * @return void
		 * @author 
		 **/
		public function __mysqlColumns(array $columns = [])
		{
			$this->__mysqlColumns = $columns;
			return $this;
		}

        /**
         * undocumented function
         *
         * @return MysqlDatabase
         * @author
         */
		public function __mysqlInsertRow()
		{
			$stmt = $this->__mysqlStart($this->__mysqlInsertStmt()->__mysqlInsert);
			$columns = ! empty($this->__mysqlColumns)?$this->__mysqlColumns:
						$this->__mysqlTableDefinition()->__mysqlTableFields;

			if(! empty($stmt))
				$this->feedback = $stmt->execute(
					$this->__mysqlValidate(
						$this->unsetParams(
							$columns
						)
					)->__mysqlValidatedParams
				);

			return $this;
		}

		/**
		 * undocumented function
		 *
		 * @return void
		 * @author 
		 **/
		public function __mysqlValidate(array $data = [])
		{
			$formData = ! empty($data)?$data:$this->post();

			$columns = [];
			$compatibleData = [];

			foreach ($this->__mysqlTableFields as $key => $value)
				$columns[$value] = $value;

			foreach ($formData as $formDataNameAttribute => $value) {
				if(array_key_exists($formDataNameAttribute ,$columns))
					$compatibleData[$formDataNameAttribute] = $value;
				else
					unset($formData[$formDataNameAttribute]);
			}

			$this->__mysqlValidatedParams = $compatibleData;
			return $this;
		}

		/**
		* undocumented function
		*
		* @return string
		* @author 
		**/
		public function __mysqlInsertStmt()
		{

			$columns = $this->__mysqlTableDefinition()->__mysqlTableFields;

			foreach ($columns as $key => $value) 
				$columnsHtmlFieldsData[$value] = $value;

			$insertionQuery = ":".implode(', :', array_keys($columnsHtmlFieldsData));

			foreach ($columns as $key => $value) {
				if(!is_numeric($key)){
					$valueToSearch = ':'.$value;

					$replacedString = str_replace($valueToSearch, $value, $insertionQuery);
					if ($replacedString)
						$insertionQuery = $replacedString;
					else {
						$valueToSearch = ':'.$value.', ';
						$insertionQuery = str_replace($valueToSearch, $value, $insertionQuery);
					}
				}
			}

			$this->__mysqlInsert = 'INSERT INTO '.$this->table.' VALUES('.$insertionQuery.');';
			return $this;
		}

        /**
         * undocumented function
         *
         * @return MysqlDatabase
         * @author
         */
		protected function __mysqlTableDefinition()
		{
			$this->qry = "SHOW COLUMNS FROM $this->table;";
			$rows = $this->__mysqlSelect()->__mysqlRows;

			foreach ($rows as $row => $column) {
				$columnHasDefaults = $this->__mysqlFilter($column)->__mysqlDefaultFields;
				if($columnHasDefaults)
					$columns[$column['Field']] = $columnHasDefaults;
				else
					$columns[] = $column['Field'];
			}
			$this->__mysqlTableFields = $columns;
			return $this;
		}

		/**
		 * undocumented function
		 *
		 * @return void
		 * @author 
		 **/
		protected function __mysqlSelect()
		{
			$this->__mysqlRows = $this->_mysqlFetch($this->__mysqlStart("SELECT * FROM $table_name"));
			return $this;
		}

		/**
		* undocumented function
		*
		* @param $pdo
		* @param null $counter
		* @return false
		* @author
		*/
		protected function _mysqlFetch($pdo, $counter = null)
		{
			if($pdo->execute()){

				switch ($counter) {
					case $this->__mysqlAll:
						$rows = $pdo->fetchAll(PDO::FETCH_ASSOC);
						break;

					default:
						$rows = $pdo->fetch(PDO::FETCH_ASSOC);
						break;
				}

				$this->__mysqlRows = $rows;
				return $this;
			} else return false;
		}

        /**
         * undocumented function
         *
         * @param $tblColumns
         * @return MysqlDatabase
         * @author
         */
		protected function __mysqlFilter($tblColumns){
			if ($tblColumns['Extra'])
				$this->__mysqlDefaultFields = $this->__mysqlSetDefaults($tblColumns);
			return $this;
	 	}

        /**
         * undocumented function
         *
         * @param $columns
         * @return string
         * @author
         */
	 	protected function __mysqlSetDefaults($columns){
			$column = [];
			foreach ($columns as $sqlTableDefinitionName => $value) {

              // if (in_array($sqlTableDefinitionName, $__mysqlColumnsDefinitions)) {
              	// if ($this->sqlDefaultFieldIsSet($sqlTableDefinitionName)) {
					switch ($sqlTableDefinitionName) {
                     /* case 'Null':
                          $defaultParams[$column['Field']] = $this->__mysqlColumnsDefinitions[$sqlTableDefinitionName][$value];
                          break;*/

						case 'Extra':
                          $column['Field'] = $this->__mysqlColumnsDefinitions[$sqlTableDefinitionName][$value];
                          break;

                      /*case 'Default':
                          $defaultParams[$column['Field']] = $this->__mysqlColumnsDefinitions[$sqlTableDefinitionName][$value];
                          break;*/
						                      
						default:
                          // return false;
                          break;
	                  }
	              // }
				// }
			}

			return $column['Field'];
		}

        /**
         * undocumented function
         *
         * @param $results
         * @param array $parameters
         * @return false
         * @author
         */
		public function __mysqlBindData($results ,$parameters = []){
          if(is_array($parameters)){
              foreach ($parameters as $key => $value)
              	$results->bindValue(':'.$key, $value);

              return $results;
          }

          return false;
      }
	} // END MysqlDatabase

	return new MysqlDatabase; 
