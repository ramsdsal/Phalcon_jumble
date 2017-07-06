<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class BlogPostController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for blog_post
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'BlogPost', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $blog_post = BlogPost::find($parameters);
        if (count($blog_post) == 0) {
            $this->flash->notice("The search did not find any blog_post");

            $this->dispatcher->forward([
                "controller" => "blog_post",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $blog_post,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a blog_post
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $blog_post = BlogPost::findFirstByid($id);
            if (!$blog_post) {
                $this->flash->error("blog_post was not found");

                $this->dispatcher->forward([
                    'controller' => "blog_post",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $blog_post->id;

            $this->tag->setDefault("id", $blog_post->id);
            $this->tag->setDefault("title", $blog_post->title);
            $this->tag->setDefault("content", $blog_post->content);
            $this->tag->setDefault("created_at", $blog_post->created_at);
            $this->tag->setDefault("updated_at", $blog_post->updated_at);
            
        }
    }

    /**
     * Creates a new blog_post
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'index'
            ]);

            return;
        }

        $blog_post = new BlogPost();
        $blog_post->title = $this->request->getPost("title");
        $blog_post->content = $this->request->getPost("content");
        $blog_post->created_at = $this->request->getPost("created_at");
        $blog_post->updated_at = $this->request->getPost("updated_at");
        

        if (!$blog_post->save()) {
            foreach ($blog_post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("blog_post was created successfully");

        $this->dispatcher->forward([
            'controller' => "blog_post",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a blog_post edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $blog_post = BlogPost::findFirstByid($id);

        if (!$blog_post) {
            $this->flash->error("blog_post does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'index'
            ]);

            return;
        }

        $blog_post->title = $this->request->getPost("title");
        $blog_post->content = $this->request->getPost("content");
        $blog_post->created_at = $this->request->getPost("created_at");
        $blog_post->updated_at = $this->request->getPost("updated_at");
        

        if (!$blog_post->save()) {

            foreach ($blog_post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'edit',
                'params' => [$blog_post->id]
            ]);

            return;
        }

        $this->flash->success("blog_post was updated successfully");

        $this->dispatcher->forward([
            'controller' => "blog_post",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a blog_post
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $blog_post = BlogPost::findFirstByid($id);
        if (!$blog_post) {
            $this->flash->error("blog_post was not found");

            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'index'
            ]);

            return;
        }

        if (!$blog_post->delete()) {

            foreach ($blog_post->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "blog_post",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("blog_post was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "blog_post",
            'action' => "index"
        ]);
    }

}
