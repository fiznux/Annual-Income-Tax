<?php

class Tax
		{
			Protected $amount = array( 50000000, 250000000, 500000000 );
			Protected $rate =  array( 5, 15, 25, 30 );
			Public $result;
			Public $pieces;
			Public $table;
			

			public function Income($salary) {				
				$this->breakInto($salary);
				
				$result = 0;
				for ($y=0; $y < count($this->amount);$y++){
					
					if ($y > count($this->amount)){
						$this->rate[$y] = $this->rate[count($this->rate)];
					}
					$result += ($this->pieces[$y] * ($this->rate[$y] / 100));
					
					if ($this->pieces[$y]){
						$this->table[] = array(
							'part' => number_format($this->pieces[$y]),
							'rate' => $this->rate[$y],
							'result' => number_format ($this->pieces[$y] * ($this->rate[$y] / 100))
						);
					}
				}
				
				$this->result = $result;
			}
			
			public function breakInto($income){
				$breakInto = '';
				for ($i=0; $i<count($this->amount);$i++){
					if (($income - $this->amount[$i]) >= 0){
						$breakInto[$i] = $this->amount[$i];
						$income -= $this->amount[$i];
					}else{
						$breakInto[$i] = $income;
						break;
					}
				}
				
				$this->pieces = $breakInto;
			}
			
			public function TaxCount(){
				return($this->result);
			}
			
			public function drawAsTable(){
				$table = '<table border=1>';
				$table .= '<tr>';
				$table .= '<th>Amount</th>';
				$table .= '<th>Rate</th>';
				$table .= '<th>Tax</th>';
				$table .= '</tr>';
				
				foreach($this->table as $data){
					$table .= '<tr>';
					$table .= '<td>'.$data['part'].'</td>';
					$table .= '<td>'.$data['rate'].'</td>';
					$table .= '<td>'.$data['result'].'</td>';
					$table .= '</tr>';
				}
				
				$table .= '<tr>';
					$table .= '<td colspan=2>Total</td>';
					$table .= '<td>'.number_format($this->result).'</td>';
					$table .= '</tr>';
				
				$table .= '</table>';
				return $table;
			}
		}
		
		$tax = new Tax();
		$salary = 75000000;
		$tax->Income($salary);
		
		echo 'Salary : '.(number_format($salary)).'<br>';
		echo 'Tax : '.number_format($tax->TaxCount()).'<br>';
		echo 'Tax Table <br>'.($tax->drawAsTable());

?>
