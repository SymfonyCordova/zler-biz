{!! $phpStart !!}
namespace Biz\{{$moduleName}}\Service\Impl;

use Biz\{{$moduleName}}\Dao\{{$bigName}}Dao;
use Biz\{{$moduleName}}\Service\{{$bigName}}Service;
use Zler\Biz\Service\BaseService;
use Zler\Biz\Common\ArrayToolkit;

class {{$bigName}}ServiceImpl extends BaseService implements {{$bigName}}Service
{
    public function get{{$bigName}}($id)
    {
        return $this->get{{$bigName}}Dao()->get($id);
    }

    public function create{{$bigName}}(array ${{$smallName}})
    {
        ${{$smallName}} = $this->filterCreate{{$bigName}}Fields(${{$smallName}});

        return $this->get{{$bigName}}Dao()->create(${{$smallName}});
    }

    public function update{{$bigName}}($id, array $fields)
    {
        ${{$smallName}} = $this->get{{$bigName}}($id);

        if(empty(${{$smallName}})){
            throw $this->createServiceException('xxx不存在');
        }

        $fields = $this->filterUpdate{{$bigName}}Fields($fields);

        return $this->get{{$bigName}}Dao()->update($id, $fields);
    }

    public function find{{$bigPluralName}}ByIds($ids)
    {
        return ArrayToolkit::index($this->get{{$bigName}}Dao()->findByIds($ids), 'id');
    }

    public function search{{$bigPluralName}}($conditions, $orderBy, $start = 0, $limit = 15)
    {
        return $this->get{{$bigName}}Dao()->search($conditions, $orderBy, $start, $limit);
    }

    public function count{{$bigPluralName}}($conditions)
    {
        return $this->get{{$bigName}}Dao()->count($conditions);
    }

    public function delete{{$bigName}}($id)
    {
        return $this->get{{$bigName}}Dao()->delete($id);
    }

    private function filterCreate{{$bigName}}Fields($fields){
        $requiredFields = array(

        );

        if(!ArrayToolkit::requires($fields, $requiredFields)){
            throw $this->createServiceException('缺少必要参数，添加xxx失败');
        }

        $default = array(
        {!! $tableFieldsWithDefaultValue !!}
        );

        $fields = ArrayToolkit::parts($fields, array_merge($requiredFields, array_keys($default)));
        $fields = array_merge($default, $fields);

        return $fields;
    }

    private function filterUpdate{{$bigName}}Fields($fields){
        $fields =  ArrayToolkit::parts($fields, array(
        {!! $tableFields !!}
        ));

        return $fields;
    }

    /**
    * @return {{$bigName}}Dao
    */
    private function get{{$bigName}}Dao()
    {
        return $this->biz->dao("{{$moduleName}}:{{$bigName}}Dao");
    }

}

