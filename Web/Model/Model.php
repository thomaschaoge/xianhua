<?php
//�Զ���Model�࣬��װ��PDO

class Model
{
    protected $pdo = null;
    protected $tabName; //����
    protected $pk = "id"; //�����ֶ���
    protected $fields = array(); //��ǰ���ֶ�����Ϣ
    protected $limit=null; //��ҳ��Ϣ
    protected $where = array(); //��װ��������������
    protected $order = null; //��װ��������������
    
    //���췽��
    public function __construct($tabName)
    {
        $this->tabName = $tabName;
        $this->pdo = new PDO(DSN,USER,PASS);
        //�����ֶ���Ϣ
        $this->loadFields();
    }
    //��ȡpdo����ķ���
    public function getPdo()
    {
        return $this->pdo;
    }
    //˽�з�����ȡ��ǰ����ֶ���Ϣ
    private function loadFields()
    {
        $sql  = "desc {$this->tabName}";
        $stmt = $this->pdo->query($sql);
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($list as $vo){
            //��װ�ֶ���Ϣ
            $this->fields[] = $vo['Field'];
            //�ж��Ƿ�������
            if($vo['Key']=="PRI"){
                $this->pk = $vo['Field']; 
            }
        }
    }
    
    //��ȡ��Ϣ
    public function select()
    {
        $sql = "select * from {$this->tabName}";
        
        //�жϲ���װ�������
        if(count($this->where)>0){
            $sql .= " where ".implode(" and ",$this->where);
        }
        //�жϲ���װ��������
        if(!empty($this->order)){
            $sql .= " order by ".$this->order;
        }
        //�жϲ���װ��ҳ���
        if(!empty($this->limit)){
            $sql .= " limit ".$this->limit;
        }
        //echo $sql."<br/>";
        $stmt = $this->pdo->query($sql);
        
        //�����������ҳ�����
        $this->where = array();
        $this->order = null;
        $this->limit = null;
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //��ȡ����sqlִ�����
    public function query($sql)
    {
        //$sql = "select * from {$this->tabName}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //��ȡ������Ϣ
    public function find($id)
    {
        $sql = "select * from {$this->tabName} where {$this->pk}={$id}";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //ִ��ɾ��
    public function del($id)
    {
        $sql = "delete from {$this->tabName} where {$this->pk}={$id}";
        return $this->pdo->exec($sql);
    }
    
    //ִ�����
    public function insert($data=array())
    {
        //�жϲ�����û��ֵ���Բ���POST�л�ȡ
        if(empty($data)){
            $data = $_POST;
        }
        $fieldlist = array(); //�������ڷ�װ�ֶεı���
        $valuelist = array(); //�������ڷ�װֵ�ı���
        //����Ҫ��ӵ���Ϣ����װ
        foreach($data as $k=>$v){
            //�ж�k�Ƿ�Ϊ��Ч�ֶ�
            if(in_array($k,$this->fields)){
                $fieldlist[] = $k;
                $valuelist[] = "'".$v."'";
            } 
        }
        //ƴװ���sql���
        $sql = "insert into {$this->tabName}(".implode(",",$fieldlist).") values(".implode(",",$valuelist).")";
        //ִ�з���Ӱ������
        //echo $sql;
        return $this->pdo->exec($sql);
    }
    
    //ִ���޸�
    public function update($data=array())
    {
        //�жϲ�����û��ֵ���Բ���POST�л�ȡ
        if(empty($data)){
            $data = $_POST;
        }
        $fieldlist = array(); //�������ڴ洢�޸���Ϣ
        //����Ҫ�޸ĵ���Ϣ����װ
        foreach($data as $k=>$v){
            //�ж�k�Ƿ�Ϊ��Ч�ֶ�,���Ҳ�Ϊ����
            if(in_array($k,$this->fields) && $k!=$this->pk){
                $fieldlist[] = "{$k}='{$v}'";
            } 
        }
        //ƴװ�޸�sql���
        $sql = "update {$this->tabName} set ".implode(",",$fieldlist)." where {$this->pk}={$data[$this->pk]}";
        //ִ�з���Ӱ������
        //echo $sql;
        return $this->pdo->exec($sql);
    }
    
    //ͳ������
    public function count()
    {
        $sql = "select count(*) as num from {$this->tabName}";
        
        //�жϲ���װ�������
        if(count($this->where)>0){
            $sql .= " where ".implode(" and ",$this->where);
        }
        
        $stmt = $this->pdo->query($sql);
        $vo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $vo['num']; //���ؽ��
    }
    
    //��װwhere����
    public function where($where)
    {
        $this->where[] = $where;
        return $this;
    }
    
    //��װorder by����
    public function order($order)
    {
        $this->order = $order;
        return $this;
    }
    
    //��װ��ҳlimit
    public function limit($m,$n=0)
    {
        if($n==0){
            $this->limit = $m;
        }else{
            $this->limit = $m.",".$n;
        }
        return $this;
    }
}