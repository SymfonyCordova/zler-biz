{!! $phpStart !!}
namespace Biz\{{$moduleName}}\Dao\Impl;

use Zler\Biz\Dao\AdvancedDaoImpl;
use Biz\{{$moduleName}}\Dao\{{$bigName}}Dao;

class {{$bigName}}DaoImpl extends AdvancedDaoImpl implements {{$bigName}}Dao
{
    protected $table = "{{$tableName}}";

    public function declares()
    {
        return array(
            'timestamps' => array('create_time','update_time'),
            'serializes' => array(),
            'orderbys' => array(),
            'conditions' => array(),
        );
    }

    public function findByIds($ids)
    {
        return $this->findInField('id', $ids);
    }
}

