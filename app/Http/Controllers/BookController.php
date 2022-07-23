<?php

namespace App\Http\Controllers;

use App\Models\Contact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
/**
 * @Info(
 *     title="Записная книжка",
 */
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        /**
         * @OA\Get(
         *     path="/api/v1/notebook/",
         *     summary="Просмотр контактов",
         *
         *     description="Все контакты",
        @OA\Parameter(name="page", in="query",description="Номер страницы", required=false,
         *        @OA\Schema(type="integer")
         *    ),
         * @OA\Response(
         *          response=200, description="Success",
         *          @OA\JsonContent(
         *             @OA\Property(property="status", type="integer", example="200"),
         *             @OA\Property(property="data",type="object")
         *          )
         *       )
         * )
         */
        try {
            $contacts = Contact::paginate(1);
            return response()->json(['status' => 200, 'data' => $contacts]);
        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @OA\Post(
         *              path="/api/v1/notebook/",
         *
         *              summary="Создать контакт",
         *
         *   @OA\Response(response="404", description="Ошибка"),
         *  @OA\Response(response="200", description="Операция успешно выполнена"),
         *      @OA\Parameter(
         *              name="full_name",
         *              in="query",
         *              required=true,
         *      @OA\Schema(
         *              type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="company",
         *           in="query",
         *           required=false,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="phone",
         *           in="query",
         *           required=true,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="email",
         *           in="query",
         *           required=true,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *   @OA\Parameter(
         *              name="date_birthday",
         *              in="query",
         *              required=false,
         *   @OA\Schema(
         *              type="date"
         *      )
         *   ),
        @OA\RequestBody(required=false,
        @OA\MediaType(mediaType="multipart/form-data",
         * @OA\Schema(
         * @OA\Property(description="Загрузка изображений",property="photo",type="file",format="file")
         * )
         * )
         * )
         * )
         */
        $valid = Validator::make($request->all(), [
            'full_name' => 'required',
            'photo' => 'required|file|mimes:jpg,png',
            'phone' => 'required',
            'email' => 'required',
            'date_birthday' => 'date',
        ]);
        if ($valid->fails())
            return response($valid->errors(), 422);
        $photo = Contact::create([
            'full_name' => $request->full_name,
            'company' => $request->company, 'phone' => $request->phone,
            'email' => $request->email, 'date_birthday' => $request->date_birthday,
            'photo' => explode('/', $request->file('photo')->store('public'))[1]]);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         * @OA\Get(
        path="/api/v1/notebook/{id}/",
         *    operationId="Выбранный контакт",
         *    summary="Показать контакт",
         *    @OA\Parameter(name="id", in="path", description="ID", required=true,
         *        @OA\Schema(type="integer")
         *    ),
        @OA\Response(response="400", description="Ошибка"),
         *  @OA\Response(response="200", description="Операция успешно выполнена")
         *           )
         *        )
         *       )
         * )
         *
         */
        $contact = Contact::where('id', $id)->get();
        if ($contact->count() !== 0)
            return response()->json(['status' => 200, 'data' => $contact]);
        return response()->json(['status' => 404, 'message' => 'Ошибка']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * /*
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateContact(Request $request, $id)
    {
        /**
         * @OA\Put (
         *              path="/api/v1/notebook/{id}",
         *
         *              summary="Редактирование контакта",
         *
         *
         *  @OA\Response(response="200", description="Операция успешно выполнена"),
         *  @OA\Parameter(name="id", in="path", required=true,
         *          @OA\Schema(type="integer")
         * ),
         *      @OA\Parameter(
         *              name="full_name",
         *              in="query",
         *              required=false  ,
         *      @OA\Schema(
         *              type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="company",
         *           in="query",
         *           required=false,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="phone",
         *           in="query",
         *           required=false ,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *    @OA\Parameter(
         *           name="email",
         *           in="query",
         *           required=false ,
         *    @OA\Schema(
         *           type="string"
         *      )
         *   ),
         *   @OA\Parameter(
         *              name="date_birthday",
         *              in="query",
         *              required=false,
         *   @OA\Schema(
         *              type="date"
         *      )
         *   ),
         * @OA\RequestBody(
         *         required=false,
         *         @OA\MediaType(
         *             mediaType="multipart/form-data"      ,
         *             @OA\Schema(
         *                 @OA\Property(
         *                     description="Загрузка файла  ",
         *                     property="photo",
         *                     type="file",
         *
         *                ),
         *
         *             )
         *         )
         *     ))
         */
        $valid = Validator::make($request->all(), [
            'photo' => 'mimes:jpg,png',
        ]);
        if ($valid->fails())
            return response($valid->errors(), 422);
        try {
            $query = Contact::where('id', $id)->get();
            $file = $request->file('photo');
            if ($query->count() !== 0) {
                foreach ($query as $contact)
                    $contact->full_name = ($request->has('full_name') ? $request->full_name : $contact->full_name);
                $contact->company = ($request->has('company') ? $request->company : $contact->company);
                $contact->phone = ($request->has('phone') ? $request->phone : $contact->phone);
                $contact->email = ($request->has('email') ? $request->email : $contact->email);
                $contact->date_birthday = ($request->has('date_birthday') ? $request->date_birthday : $contact->date_birthday);
                $contact->photo = (($file) ? $request->file('photo')->$request->file('photo') : $contact->photo);


                Contact::find($id)->update(
                    [
                        'full_name' => $contact->full_name,
                        'company' => $contact->company,
                        'phone' => $contact->phone,
                        'email' => $contact->email,
                        'date_birthday' => $contact->date_birthday,
                        'photo' => $contact->photo
                    ]
                );

                return response()->json(['status' => 200, 'data' => 'Контакт успешно изменен']);
            }
        }
        catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);


        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /**
         * @OA\Delete(
         *    path="/api/v1/notebook/{id}/",
         *
         *
         *    summary="Удаление контакта",
         *    description="Удаление контакта",
         *    @OA\Parameter(name="id", in="path", description="Id", required=true,
         *        @OA\Schema(type="integer")
         *    ),
         *      *   @OA\Response(response="404", description="Ошибка, контакт не найден"),
         *  @OA\Response(response="200", description="Операция успешно выполнена"),
         *  )
         */

        try {
            $contact = Contact::where('id',$id);
            if ($contact->count() !== 0) {
                $contact->delete();
                return response()->json(['status' => 200, 'data' => 'Контакт удалены']);
            } else {
                return response()->json(['status' => 404, 'message' => 'Ошибка контакт не найден   ']);
            }

        } catch (Exception $e) {
            return response()->json(['status' => 400, 'message' => $e->getMessage()]);
        }

    }
}
