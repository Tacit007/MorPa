<?php

/**
 * This is the model class for table "newsEntry".
 *
 * The followings are the available columns in table 'newsEntry':
 * @property integer $id
 * @property string $title
 * @property string $link
 */
class NewsEntry extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'newsEntry';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'length', 'max'=>35),
            array('link', 'length', 'max'=>200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, link', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('link',$this->link,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return NewsEntry the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    /*public static function feedToNews($feedURL){
        $content = file_get_contents($feedURL);
        $x = new SimpleXmlElement($content);

        foreach($x->channel->item as $entry) {
            $list[] = $entry;
        }
        
        Kint::dump($entry);
        
        foreach($list as $entry) {
            $aLink = $entry->link;
            $aTitle = substr($entry->title, 0, 500);
            $aDate = DateTime::createFromFormat(DateTime::RSS, $entry->pubDate)->format("Y-m-d H:i:s");
            $feedID = mysql_fetch_assoc(mysql_query(
            "SELECT id FROM feed WHERE feedURL='".$feedURL."';"
        )); $feedID = $feedID['id'];
            
            $sql = "INSERT INTO newsEntry (link, title, date, feedID) VALUES ( '$aLink', '$aTitle', '$aDate', '$feedID');";

            //echo $sql."<br><br>";
            mysql_query($sql);
        
        /* $sql = "
            DELETE newsEntry 
            FROM newsEntry
            LEFT OUTER JOIN (
               SELECT MIN(id) as id, title
               FROM newsEntry 
               GROUP BY title
            ) as KeepRows ON
               newsEntry.id = KeepRows.id
            WHERE
               KeepRows.id IS NULL
        ";
        //echo $sql;
        $command = Yii::app()->db->createCommand($sql)->execute();*/
        }
    }
    
    public static function feedToList($feedURL){
        $content = file_get_contents($feedURL);
        $x = new SimpleXmlElement($content);
        //Kint::dump($x->channel);
        foreach($x->channel->item as $entry) {
            $list[] = $entry;
        }

        echo "<ul>";
        foreach($list as $entry) {
            echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
        }
        echo "</ul>";
    }*/
}